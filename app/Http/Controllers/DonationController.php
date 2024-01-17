<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Handlers\DonationHandler;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
class DonationController extends Controller
{
    protected $donationHandler;

    function __construct(DonationHandler $donationHandler){
        $this->donationHandler =  $donationHandler;
    }

    public function donors()
    {
        return view('donors.index');
    }

    public function donations()
    {
        return view('donations.index');
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
}
