<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\{DonationHandler , CampaignHandler , MembershipHandler};
use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stripe\{SetupIntent , Account};
use Stripe\Stripe;


class DonationController extends Controller
{
    protected $donationHandler;
    protected $campaignHandler;
    protected $membershipHandler;

    function __construct(DonationHandler $donationHandler , CampaignHandler $campaignHandler , MembershipHandler $membershipHandler){
        $this->donationHandler =  $donationHandler;
        $this->campaignHandler = $campaignHandler;
        $this->membershipHandler = $membershipHandler;
    }

    public function donors(Request $request)
    {

        $donations = $this->donationHandler->getRecentDonars($request);
        [$monthlyPlans , $annuallyPlans] = $this->membershipHandler->membershipPlanList();
        return view('donors.index')->with(["donations" => $donations , 'monthlyPlans' => $monthlyPlans , 'annuallyPlans' => $annuallyPlans]);
    }

    public function donations()
    {
        $campaigns = $this->campaignHandler->getUserCampaigns();

        [$recievedAmount , $totalAmount , $failedAmount] = $this->donationHandler->getDonationStats();

        $members = $this->membershipHandler->getSubscribeMembers();
    
        return view('donations.index')->with(['recievedAmount' => $recievedAmount , 'totalAmount' => $totalAmount , 'failedAmount' => $failedAmount , 'campaigns' => $campaigns , 'members' => $members]);
    }

    public function getDonationList(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'status' => 'nullable|string',
            'campaignId' => 'nullable|string',
            'upperDate' => 'nullable|date',
            'lowerDate' => 'nullable|date'
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'error' => implode("," ,$validator->errors()->all())]);
        }

        return $this->donationHandler->getDonations($request);

    }

    public function getDonationForm(Request $request)
    {
        try{
            $campaignId = $request->campaign_id;
            [$campaign , $countries , $userPlans] = $this->donationHandler->getCampaignDonation($campaignId);
            $connectedId  = $this->donationHandler->getConnectedId($campaignId);
            Stripe::setApiKey(env('STRIPE_SECRET'));
            // $account = Account::retrieve('acct_1OironBUcsb6xhsC');
            $setupIntent = SetupIntent::create(['usage' => 'on_session'] , ['stripe_account' => $connectedId]);
            return view('public.donate.card')->with(['campaign' => $campaign , 'countries' => $countries , 'clientSecret' => $setupIntent->client_secret ,'userPlans' => $userPlans , 'connectedId' => $connectedId]);
            
        }catch(\Exception $e){
            return redirect()->back();
        }
    }

    public function addDonation(Request $request)
    {
        $validator  = Validator::make($request->all() , [
            'campaign_id' => 'required|numeric',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'country' => 'required|numeric',
            'city' => 'required|numeric',
            'frequency' => 'nullable|string',
            'price_option' => 'required_if:frequency,!=,null',
            'amount' => 'required_if:frequency,==,null',
            'street' => 'required|string'
        ]);


        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => implode("," , $validator->messages()->all())]);
        }

        try{
             $response = $this->donationHandler->createDonation($request);
             return response()->json($response);
        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => $e->getMessage()]);
        }

    }

    public function getDonationDashboardStats(Request $request){
        $validator = Validator::make($request->all() , [
            'status' => 'nullable|string',
            'campaignId' => 'nullable|string',
            'upperDate' => 'nullable|date',
            'lowerDate' => 'nullable|date'
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'error' => implode("," ,$validator->errors()->all())]);
        }


        try{
        $recievedAmount = $totalAmount = $failedAmount = $failedRecievedAmount = 0; 

        if(isset($request->status)){

            switch($request->status){
                case \AppConst::DONATION_FAILED:
                    [$failedAmount , $failedRecievedAmount] = $this->donationHandler->calculateDonationAmount($request->status , false ,  $request->campaignId , $request->upperDate , $request->lowerDate );
                    $requestStatus = \AppConst::DONATION_FAILED;
                break;
                case \AppConst::DONATION_COMPLETED:
                    [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount($request->status , false , $request->campaignId , $request->upperDate , $request->lowerDate );
                    $requestStatus = \AppConst::DONATION_COMPLETED;
                break;
            }
        }else{
            [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_COMPLETED , false , $request->campaignId , $request->upperDate , $request->lowerDate );
            [$failedAmount , $failedRecievedAmount ] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_FAILED , false ,  $request->campaignId , $request->upperDate , $request->lowerDate );
            
            
        }

        return response()->json([
                'status' => true,
                'recievedAmount' => '$'.number_format($recievedAmount , 2), 
                'totalAmount' => '$'.number_format($totalAmount , 2), 
                'failedAmount' => '$'.number_format($failedAmount , 2), 
                'failedRecievedAmount' => '$'.number_format($failedRecievedAmount , 2),
            ]);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'error' => $e->getMessage(), 'msg' => 'Something Went Wrong While Loading Stats']);
        }


    }
}
