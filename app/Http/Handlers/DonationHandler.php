<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{ Donation , Campaign , Country , User , PlatformPercentage , Address, PriceOption , Plan};
use App\Http\Handlers\{StripeHandler , MailChimpHandler};
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Stripe\{Stripe , Transfer};

class DonationHandler{

    public function getCampaignDonation($campaignId)
    {   
        $campaign = Campaign::with('donations' , 'frequencies' , 'priceOptions')->where('id' , $campaignId)->first();
        $countries = Country::all();
        $userPlans = Plan::where('user_id' , auth()->user()->id)->get();
        return [$campaign , $countries , $userPlans];
    }

    public function getDonationStats(){
        [$recieveAmount , $totalAmount] = $this->calculateDonationAmount(\AppConst::DONATION_COMPLETED , true);
        [$failedRecieveAmount , $failedTotalAmount] = $this->calculateDonationAmount(\AppConst::DONATION_FAILED , true);

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
        // dd($request->all());
        $campaignId = $request->campaign_id;

        $percentageId = PlatformPercentage::latestPercentage()->id;

        //set percentage when split payment has been discussed
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $plan = isset($request->frequency) ? Plan::with('monthlyInterval' , 'quarterlyInterval' , 'yearlyInterval')->where('id' , $request->plan_id)->first() : null;
        $amount = isset($request->frequency) ? Plan::where('id' , $request->plan_id)->first()->amount : $request->amount;
        $connectedAccountId = Campaign::with('user')->where('id' , $campaignId)->first()->user->stripe_connected_id;
        

        if(!isset($request->frequency))
        {
            $transfer = Transfer::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'destination' => $connectedAccountId,
            ]);

            if($transfer->id){
                $donation = new Donation;
                $donation->campaign_id = $campaignId;
                isset($request->frequency) ? $donation->price_option_id = $request->price_option : $donation->amount = $request->amount;
                $donation->status = "completed";
                $donation->percentage_id = $percentageId;
                $donarId = $this->createDonar($request);
                $donation->donar_id = $donarId; 
                $donation->transfer_id = $transfer->id;
                $donation->save();
                \Helper::sendMail(\AppConst::DONATION_SUCCESS , $request->email);
                return ['status' => true , 'msg' => 'Donation Added Successfully'];
            }else{
                return ['status' => false , 'error' => 'Something Went Wrong' , 'msg' => 'Something went wrong while adding donation'];
            }



        }else{
        
            try{
                
                $donarId = $this->createDonar($request);

                $user = User::where('id' , $donarId)->first();

                if(!$user->stripe_id){
                    $user->createAsStripeCustomer();
                }

                $request->user()->updateDefaultPaymentMethod($request->payment_method);
                $subscription = null;

             
                switch($request->frequency){
                    case 'monthly':
                        $subscription = $user->subscription('plan_PY5AY04nAoCuw4')->create($request->paymentMethod);
                    break;
                    case 'quarterly':
                        $subscription = $user->newSubscription('default' , $plan->quarterlyInterval->stripe_plan_id)->create($request->paymentMethod);
                    break;
                    case 'annually':
                        $subscription = $user->newSubscription('default' , $plan->yearlyInterval->stripe_plan_id)->create($request->paymentMethod);
                    break;
                }
                
                if($subscription){
                    \Helper::sendMail(\AppConst::SUBSCRIPTION_SUCCESS , $request->email);
                    return ['status' => true , 'msg' => 'Subscription Added Successfully'];
                }else{
                    return ['status' => true , 'msg' => 'Something Went Wrong' , 'error' => 'While Creating Subscription'];
                }
            }
            catch(\Exception $e){
                return ['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()];
            }


        }


        // if($transfer->id){
            
        //     $donation = new Donation;
        //     $donation->campaign_id = $campaignId;
        //     isset($request->frequency) ? $donation->price_option_id = $request->price_option : $donation->amount = $request->amount;
        //     $donation->status = "completed";
        //     $donation->percentage_id = $percentageId;
        //     $donarId = $this->createDonar($request);
        //     $donation->donar_id = $donarId; 
        //     $donation->transfer_id = $transfer->id;
        //     $donation->save();
    
        //     $campaignCreator = User::with('mailchimp')->whereHas('campaigns' , function($query) use ($campaignId){
        //                                         $query->where('id' , $campaignId);
        //                                 })->first();
    
        //     if($campaignCreator->mailchimp){
        //         $mailchimp = new MailChimpHandler($campaignCreator->mailchimp->api_key);
        //         if(!$mailchimp->findSubscriber($campaignCreator->mailchimp->list_id , $request->email)){
        //             $mailchimp->addSubscriber($campaignCreator->mailchimp->list_id , $request->email);
        //         }
        //     }


           
    
        //     if($donarId){
        //         return ['status' => true , 'msg' => 'Donation added successfully'];
        //     }else{
        //         return ['status' => false , 'error' => 'Something Went Wrong' , 'msg' => 'Something went wrong while adding donation'];
        //     }

        // }else{
        //     return ['status' => false  , 'error' => 'Something Went Wrong' ,  'msg' => 'Something went wrong while adding donation'];
        // }


        
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


    public function calculateDonationAmount($status = null , $currentMonth = null , $campaignId = null , $upperDate = null , $lowerDate = null){

        $query = Donation::query();

        $query->with('price' , 'platformPercentage');
        
        $query->when(!auth()->user()->hasRole('admin') , function($query){
            $query->whereHas('campaign' , function($query1){
                $query1->whereHas('user' , function($query2){
                    $query2->where('id' , auth()->user()->id);
                });
            });
        });

        $query->when(isset($status) && !empty($status) , function($query1) use ($status){
            $query1->where('status' , $status);
        });

        $query->when(isset($currentMonth) && $currentMonth, function($query1){
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

    public function totalDonationCount(){
        $query = Donation::query();

        $query->when( !auth()->user()->hasRole('admin') , function($query){
            $query->whereHas('campaign' ,function($query){
                $query->whereHas('user' , function($query1){
                    $query1->where('id' , auth()->user()->id);
                });
            });
        });

        $totalDonation = $query->count();

        return $totalDonation;
    }

    public function getlatestDonars(){

        $query = Donation::query();

        $query->when( !auth()->user()->hasRole('admin') , function($query){
            $query->whereHas('campaign' , function($query){
                $query->where('user_id' , auth()->user()->id);
            });
        });

        $donations =$query->with('campaign' , 'price' , 'platformPercentage' , 'donar')
                        ->orderBy('id' , 'desc')
                        ->limit(10)
                        ->get();

        return $donations;
    }




}