<?php

namespace App\Http\Handlers;
use App\Models\{ Donation , Campaign , Country , User , PlatformPercentage , Address};
use App\Http\Handlers\StripeHandler;

class DonationHandler{

    protected $stripeHandler;

    function __construct(StripeHandler $stripeHandler)
    {
        $this->stripeHandler = $stripeHandler;
    }

    public function getCampaignDonation($campaignId)
    {   
        $campaign = Campaign::with('donations' , 'frequencies' , 'priceOptions')->where('id' , $campaignId)->first();
        $countries = Country::all();
        return [$campaign , $countries];
    }

    public function createDonation($request)
    {
        $percentageId = PlatformPercentage::latestPercentage()->id;
        $donation = new Donation;
        $donation->campaign_id = $request->campaign_id;
        isset($request->frequency) ? $donation->price_option_id = $request->price_option : $donation->amount = $request->amount;
        $donation->status = "completed";
        $donation->percentage_id = $percentageId;
        $donarId = $this->createDonar($request);
        $donation->donar_id = $donarId; 
        $donation->save();
        if($donarId){
            return ['status' => true , 'msg' => 'Donation added successfully'];
        }else{
            return ['status' => false , 'msg' => 'Something went wrong while adding donation'];
        }
        
    }

    public function createDonar($request){
        //check wheather user is already have donar account
        $donar = User::with('address')->where('email' , $request->email)->first();
        $donarId = null;
        if($donar){
            $donar->first_name = $request->first_name;
            $donar->last_name = $request->last_name;
            $donar->phone = $request->phone;
            $donar->save();
            
            if(!$donar->hasRole('donar')){
                $donar->assignRole('donar');
            }
            $donarId = $donar->id;

            if(!$donar->address){
                $address = new Address();
                $address->addressable_type = 'App\Models\User';
                $address->addressable_id = $donarId; 
                $address->country_id = $request->country;
                $address->city_id = $request->city;
                $address->street = $request->street;
                $address->save();
            }

            
        }else{
            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->save();
            $user->assignRole('donar');
            $donarId = $user->id;

            $address = new Address();
            $address->addressable_type = 'App\Models\User';
            $address->addressable_id = $donarId; 
            $address->country_id = $request->country;
            $address->city_id = $request->city;
            $address->street = $request->street;
            $address->save();
        }

        return $donarId;
    }

}