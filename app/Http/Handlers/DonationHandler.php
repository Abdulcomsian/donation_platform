<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{ Donation , Campaign , Country , User , PlatformPercentage , Address};
use App\Http\Handlers\{StripeHandler , MailChimpHandler};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonationHandler{

    public function getCampaignDonation($campaignId)
    {   
        $campaign = Campaign::with('donations' , 'frequencies' , 'priceOptions')->where('id' , $campaignId)->first();
        $countries = Country::all();
        return [$campaign , $countries];
    }

    public function getDonationStats(){
        [$recieveAmount , $totalAmount] = $this->calculateDonationAmount(\AppConst::DONATION_COMPLETED);
        [$failedRecieveAmount , $failedTotalAmount] = $this->calculateDonationAmount(\AppConst::DONATION_FAILED);

        return [$recieveAmount , $totalAmount , $failedTotalAmount];
    }

    public function getDonations($request){
        $campaignId = $request->campaignId;
        $status = $request->status;
        $lowerDate = $request->lowerDate;
        $upperDate = $request->upperDate;


        $query = Donation::query();

        $query->when(isset($campaignId) && !empty($campaignId) , function($query) use ($campaignId){
            $query->where('campaign_id' , $campaignId);
        });

        $query->when(isset($status) && !empty($status) , function($query) use ($status){
            $query->where('status' , $status);
        });

        $query->when(isset($lowerDate) && !empty($lowerDate) , function($query) use ($lowerDate){
            $query->where(DB::raw('Date(created_at)') , '>=' , $lowerDate);
        });

        $query->when(isset($upperDate) && !empty($upperDate) , function($query) use ($upperDate){
            $query->where(DB::raw('Date(created_at)') , '<=' , $upperDate);
        });


        $donations = $query->with('campaign' , 'donar' , 'price' , 'platformPercentage')->orderBy('id' , 'desc')->get();
        
        // $query->when(isset)

        return DataTables::of($donations)
              ->addColumn('donar' , function($donation){
                return $donation->donar->first_name.' '.$donation->donar->last_name;
              })
              ->addColumn('campaign' , function($donation){
                return $donation->campaign->title;
              })
              ->addColumn('status' , function($donation){
                switch($donation->status){
                    case \AppConst::DONATION_PENDING:
                        return '<div class="pending">Pending</div>';
                    break;
                    case \AppConst::DONATION_PROCESSING:
                        return '<div class="processing">Processing</div>';
                    break; 
                    case \AppConst::DONATION_REFUNDED:
                        return '<div class="failed">Failed</div>';
                    break; 
                    case \AppConst::DONATION_COMPLETED:
                        return '<div class="complete">Complete</div>';
                    break; 
                    default:
                        return '<div class="failed">Failed</div>';
                }
              })
              ->addColumn('amount' , function($donation){
                return $donation->price ? '$'.number_format($donation->price->amount , 2) : '$'.number_format($donation->amount , 2);
              })
              ->addColumn('fee_recovered' , function($donation){
                return $donation->price ? '$'.number_format(($donation->price->amount - (($donation->platformPercentage->percentage /100 ) * $donation->price->amount)) , 2) : '$'.number_format(($donation->amount - (($donation->platformPercentage->percentage /100 ) * $donation->amount)) , 2);
              })
              ->rawColumns(['donar' , 'campaign' , 'status' ,'amount' , 'fee_recovered'])
              ->make(true);
    }

    public function createDonation($request)
    {
        $campaignId = $request->campaign_id;

        $percentageId = PlatformPercentage::latestPercentage()->id;
        $donation = new Donation;
        $donation->campaign_id = $campaignId;
        isset($request->frequency) ? $donation->price_option_id = $request->price_option : $donation->amount = $request->amount;
        $donation->status = "completed";
        $donation->percentage_id = $percentageId;
        $donarId = $this->createDonar($request);
        $donation->donar_id = $donarId; 
        $donation->save();

        $campaignCreator = User::with('mailchimp')->whereHas('campaigns' , function($query) use ($campaignId){
                                            $query->where('id' , $campaignId);
                                    })->first();

        if($campaignCreator->mailchimp){
            $mailchimp = new MailChimpHandler($campaignCreator->mailchimp->api_key);
            if(!$mailchimp->findSubscriber($campaignCreator->mailchimp->list_id , $request->email)){
                $mailchimp->addSubscriber($campaignCreator->mailchimp->list_id , $request->email);
            }
        }


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


    public function calculateDonationAmount($status = null , $campaignId = null , $upperDate = null , $lowerDate = null){

        $query = Donation::query();

        $query->with('price' , 'platformPercentage')->whereHas('campaign' , function($query1){
            $query1->whereHas('user' , function($query2){
                $query2->where('id' , auth()->user()->id);
            });
        });

        $query->when(isset($status) && !empty($status) , function($query1) use ($status){
            $query1->where('status' , $status);
        });

        $query->when(!isset($lowerDate) && !isset($upperDate) , function($query1){
            $query1->whereRaw('YEAR(created_at) = '.now()->year.' and MONTH(created_at)='.now()->month);
        });
      
        $query->when(isset($campaignId) && !empty($campaignId) , function($query) use ($campaignId){
            $query->where('campaign_id' , $campaignId);
        });

        $query->when(isset($lowerDate) && !empty($lowerDate) , function($query) use ($lowerDate){
            $query->where(DB::raw('Date(created_at)') , '>=' , $lowerDate);
        });

        $query->when(isset($upperDate) && !empty($upperDate) , function($query) use ($upperDate){
            $query->where(DB::raw('Date(created_at)') , '<=' , $upperDate);
        });

        $donations = $query->get();

        $recievedAmount = $totalAmount = 0;
        foreach($donations as $donation){
        if($donation->price){
            $totalAmount += $donation->price->amount;
            $recievedAmount += ($donation->price->amount - (($donation->platformPercentage->percentage /100 ) * $donation->price->amount));
        }else{
            $totalAmount += $donation->amount;
            $recievedAmount += ($donation->amount - (($donation->platformPercentage->percentage /100 ) * $donation->amount));
        }
        }   

        return [$recievedAmount , $totalAmount];
    }

    public function getRecentDonars(){
        $donations = Donation::with('donar' , 'price')->orderBy('id' , 'desc')->limit(10)->get();
        return $donations;
    }

}