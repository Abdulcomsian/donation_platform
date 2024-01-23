<?php

namespace App\Http\Controllers;

use App\Http\Handlers\CampaignHandler;
use Illuminate\Http\Request;
use App\Http\Handlers\DonationHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class DonationController extends Controller
{
    protected $donationHandler;
    protected $campaignHandler;

    function __construct(DonationHandler $donationHandler , CampaignHandler $campaignHandler){
        $this->donationHandler =  $donationHandler;
        $this->campaignHandler = $campaignHandler;
    }

    public function donors()
    {
        $donars = $this->donationHandler->getRecentDonars();
        return view('donors.index')->with("donars" , $donars);
    }

    public function donations()
    {
        $campaigns = $this->campaignHandler->getUserCampaigns();

        [$recievedAmount , $totalAmount , $failedAmount] = $this->donationHandler->getDonationStats();
    
        return view('donations.index')->with(['recievedAmount' => $recievedAmount , 'totalAmount' => $totalAmount , 'failedAmount' => $failedAmount , 'campaigns' => $campaigns]);
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
            [$campaign , $countries] = $this->donationHandler->getCampaignDonation($campaignId);
            return view('public.donate.card')->with(['campaign' => $campaign , 'countries' => $countries]);
            
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
                    [$failedAmount , $failedRecievedAmount] = $this->donationHandler->calculateDonationAmount($request->status , $request->campaignId , $request->upperDate , $request->lowerDate );
                    $requestStatus = \AppConst::DONATION_FAILED;
                break;
                case \AppConst::DONATION_COMPLETED:
                    [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount($request->status , $request->campaignId , $request->upperDate , $request->lowerDate );
                    $requestStatus = \AppConst::DONATION_COMPLETED;
                break;
            }
        }else{
            [$recievedAmount , $totalAmount] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_COMPLETED , $request->campaignId , $request->upperDate , $request->lowerDate );
            [$failedAmount , $failedRecievedAmount ] = $this->donationHandler->calculateDonationAmount(\AppConst::DONATION_FAILED , $request->campaignId , $request->upperDate , $request->lowerDate );
            
            
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
