<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{ Donation , Campaign , Country , User , PlatformPercentage , Address,  Plan, PlanSubscriber, UserSubscriber};
use App\Http\Handlers\{StripeHandler , MailchimpHandler};
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\MailingJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\{Stripe , StripeClient , Customer , PaymentIntent};

class DonationHandler{

    public function getCampaignDonation($campaignId)
    {   
        $campaign = Campaign::with('user' , 'donations.plan' , 'frequencies')->where('id' , $campaignId)->first();
        $countries = Country::all();
        $userPlans = Plan::where('user_id' , $campaign->user->id)->get();
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

        $query->when(!auth()->user()->hasRole('admin') , function($query1){

            $query1->whereHas('campaign' , function($query2){
                $query2->when(auth()->user()->hasRole('owner') , function($query3){
                    $query3->where('user_id' , auth()->user()->id);
                });
                
                $query2->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('organization_admin') , function($query3){
                    $query3->where('created_by' , auth()->user()->id);
                });
            });

        });

        $donations = $query->with('campaign' , 'donar' , 'plan' , 'platformPercentage')->orderBy('id' , 'desc')->get();
        
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
                return $donation->plan ? '$'.number_format($donation->plan->amount , 2) : '$'.number_format($donation->amount , 2);
              })
              ->addColumn('fee_recovered' , function($donation){
                return $donation->plan ? '$'.number_format(($donation->plan->amount - (($donation->platformPercentage->percentage /100 ) * $donation->plan->amount)) , 2) : '$'.number_format(($donation->amount - (($donation->platformPercentage->percentage /100 ) * $donation->amount)) , 2);
              })
              ->rawColumns(['donar' , 'campaign' , 'status' ,'amount' , 'fee_recovered'])
              ->make(true);
    }

    public function createDonation($request)
    {
        $campaignId = $request->campaign_id;

        $percentageId = PlatformPercentage::latestPercentage()->id;

        //set percentage when split payment has been discussed
        // Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $plan = isset($request->frequency) ? Plan::with('user')->where('id' , $request->plan_id)->first() : null;
        // $amount = isset($request->frequency) ? Plan::where('id' , $request->plan_id)->first()->amount : $request->amount;
        $campaingDetail = Campaign::with('user')->where('id' , $campaignId)->first();
        $connectedAccountId = $campaingDetail->user->stripe_connected_id;
        $user = $campaingDetail->user;
        $options = ['stripe_account' => $connectedAccountId];
       
        if(!isset($request->frequency) && is_null($request->plan_id))
        {
            // $intent = $stripe->paymentIntents->create(
            //                             [
            //                                 'amount' => $request->amount * 100,
            //                                 'currency' => 'usd',
            //                                 'automatic_payment_methods' => ['enabled' => true],
            //                             ],
            //                             ['stripe_account' => $connectedAccountId]
            //                         );
            $customer = $this->getCustomerDetail( $request , $stripe , $options);

            $stripe->paymentMethods->attach(
                $request->payment_method,
                ['customer' => $customer->id],
                $options
            );

            
            //adding payment
            $paymentIntent = $stripe->paymentIntents->create([
                                    'amount' => $request->amount * 100,
                                    'currency' => 'usd',
                                    'payment_method' => $request->payment_method,
                                    'customer' => $customer->id,
                                    'confirm' => true,
                                    'description' => 'Plan payment',
                                    'automatic_payment_methods' => [
                                    'enabled' => true,
                                    'allow_redirects' => 'never',
                                    ],
                                ], $options);


            if($paymentIntent->id){
                $donation = new Donation;
                $donation->campaign_id = $campaignId;
                $donation->amount = $request->amount;
                $donation->status = "completed";
                $donation->percentage_id = $percentageId;
                $donarId = $this->createDonar($request);
                $donation->donar_id = $donarId; 
                $donation->payment_id = $paymentIntent->id;
                $donation->save();
                $this->addDonarOnMailchimpList($campaignId , $request->email);
                dispatch(new MailingJob(\AppConst::DONATION_SUCCESS , $request->email , $user->id));
                // \Helper::sendMail(\AppConst::DONATION_SUCCESS , $request->email);
                return ['status' => true , 'msg' => 'Donation Added Successfully'];
            }else{
                return ['status' => false , 'error' => 'Something Went Wrong' , 'msg' => 'Something went wrong while adding donation'];
            }



        }else{
            try{
                
                $donarId = $this->createDonar($request);

                $customer = $this->getCustomerDetail( $request ,$stripe , $options);

                
                $stripe->paymentMethods->attach(
                    $request->payment_method,
                    ['customer' => $customer->id],
                    $options
                );

                
                //adding payment
                $paymentIntent = $stripe->paymentIntents->create([
                                        'amount' => $plan->amount * 100,
                                        'currency' => 'usd',
                                        'payment_method' => $request->payment_method,
                                        'customer' => $customer->id,
                                        'confirm' => true,
                                        'description' => 'Plan payment',
                                        'automatic_payment_methods' => [
                                        'enabled' => true,
                                        'allow_redirects' => 'never',
                                        ],
                                    ], $options);
               

                if($paymentIntent->id){
                    //creating donar
                    $donarId = $this->createDonar($request);
    
                    //created donar as user subscriber
                    $subscriber = UserSubscriber::where('user_id' , $user->id)->where('subscriber_id' , $donarId)->first();
                    
                    if(!$subscriber){
                        $subscriber = UserSubscriber::create([
                            'user_id' => $user->id,
                            'subscriber_id' => $donarId,
                            'customer_id' => $customer->id
                        ]);
                    }
                    
                    
                    $subscriptionPlan = new PlanSubscriber;
                    $subscriptionPlan->plan_id = $request->plan_id;
                    $subscriptionPlan->subscriber_id = $donarId;
                    $subscriptionPlan->subscription_id = $subscriber->id;
                    $currentDate = Carbon::now();

                    switch($request->frequency){
                        case \AppConst::MONTHLY_INTERVAL:
                            $subscriptionPlan->interval = \AppConst::MONTHLY_INTERVAL;
                            $expiryDate = $currentDate->addMonth();
                            $subscriptionPlan->expiry_date = $expiryDate;
                        break;
                        case \AppConst::QUARTERLY_INTERVAL:
                            $subscriptionPlan->interval = \AppConst::QUARTERLY_INTERVAL;
                            $expiryDate = $currentDate->addMonth(3);
                            $subscriptionPlan->expiry_date = $expiryDate;
                        break;
                        case \AppConst::ANNUALLY_INTERVAL:
                            $subscriptionPlan->interval = \AppConst::ANNUALLY_INTERVAL;
                            $expiryDate = $currentDate->addYear(1);
                            $subscriptionPlan->expiry_date = $expiryDate;
                        break;
                    }
                    $subscriptionPlan->status = \AppConst::ACTIVE_PLAN;
                    $subscriptionPlan->campaign_id = $campaignId;
                    $subscriptionPlan->save();

                    if($subscriptionPlan->save()){

                        $donation = new Donation;
                        $donation->campaign_id = $campaignId;
                        $donation->plan_id = $request->plan_id;
                        $donation->status = "completed";
                        $donation->percentage_id = $percentageId;
                        $donation->donar_id = $donarId; 
                        $donation->payment_id = $paymentIntent->id;
                        $donation->save();
    
                        
    
                        $this->addDonarOnMailchimpList($campaignId , $request->email);
                        dispatch(new MailingJob(\AppConst::SUBSCRIPTION_SUCCESS , $request->email , $user->id));
                        // \Helper::sendMail(\AppConst::SUBSCRIPTION_SUCCESS , $request->email);
                        return ['status' => true , 'msg' => 'Subscription Added Successfully'];
                    }else{
                        return ['status' => true , 'msg' => 'Something Went Wrong' , 'error' => 'While Creating Subscription'];
                    }

                }


                // $stripe = new StripeClient(env('STRIPE_SECRET'));

                
    
            //     $stripe->paymentMethods->attach(
            //                                 $request->payment_method,
            //                                 ['customer' => $customer->id],
            //                                 $options
            //                             );

            //     $stripeCustomer = $stripe->customers->update(
            //                                 $customer->id , 
            //                                 ['invoice_settings' => 
            //                                     ["default_payment_method" =>  $request->payment_method],
            //                                 ],  
            //                                 $options
            //                             );

            //    $subscription = null; 
            //     switch($request->frequency){
            //         case 'monthly':
            //             $subscription = $stripe->subscriptions->create(
            //                 [
            //                   'customer' => $stripeCustomer->id,
            //                   'items' => [['price' => $plan->monthlyInterval->stripe_plan_id]],
            //                 ],
            //                 $options
            //               );
            //         break;
            //         case 'quarterly':
            //             $subscription = $stripe->subscriptions->create(
            //                 [
            //                   'customer' => $stripeCustomer->id,
            //                   'items' => [['price' => $plan->quarterlyInterval->stripe_plan_id]],
            //                 ],
            //                 $options
            //               );
            //         break;
            //         case 'annually':
            //             $subscription = $stripe->subscriptions->create(
            //                 [
            //                   'customer' => $stripeCustomer->id,
            //                   'items' => [['price' => $plan->yearlyInterval->stripe_plan_id]],
            //                 ],
            //                 $options
            //               );
            //         break;
            //     }
                
                
            }
            catch(\Exception $e){
                
                $donation = new Donation;
                $donation->campaign_id = $campaignId;
                $donation->amount = isset($plan) ? $plan->amount : $request->amount ;
                $donation->status = "failed";
                $donation->percentage_id = $percentageId;
                $donation->donar_id = $donarId;
                $donation->save();

                dispatch(new MailingJob(\AppConst::SUBSCRIPTION_FAILED , $request->email , $user->id));
                return ['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()];
            }


        }


        
    }

    public function getCustomerDetail($request , $stripe , $options)
    {
        $findCustomer = $stripe->customers->search([
            'query' => "email:'$request->email'",
        ], $options);
        

        $customer = null;
        if(count($findCustomer->data) == 0)
        {
            $customer = $stripe->customers->create(
                [ 'email' => $request->email, 'description' => 'donation connected account customer'],
                $options
            );

        }else{
            $customer = $findCustomer->data[0];
        }

        return $customer;
    }

    public function addDonarOnMailchimpList( $campaignId , $email) 
    {
        $campaignCreator = User::with('mailchimp')->whereHas('campaigns' , function($query) use ($campaignId){
                                                    $query->where('id' , $campaignId);
                                            })->first();
        
        if($campaignCreator->mailchimp){
            $mailchimp = new MailchimpHandler($campaignCreator->mailchimp->api_key);
            if(!$mailchimp->findSubscriber($campaignCreator->mailchimp->list_id , $email)){
                $mailchimp->addSubscriber($campaignCreator->mailchimp->list_id , $email);
            }
        }

        return true;
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

        $query->with('plan' , 'platformPercentage');
        
        $query->when(!auth()->user()->hasRole('admin') , function($query){

            $query->when(auth()->user()->hasRole('owner') , function($query){
                $query->whereHas('campaign' , function($query1){
                    $query1->whereHas('user' , function($query2){
                        $query2->where('id' , auth()->user()->id);
                    });
                });
            });

            $query->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('fundraiser') , function($query1){
               

                $query1->whereHas('campaign' , function($query2) {
                    $query2->whereHas('creator' , function($query3) {
                        $query3->where('id' , auth()->user()->id );
                    });
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
            if($donation->plan){
                $totalAmount += $donation->plan->amount;
                $recievedAmount += ($donation->plan->amount - (($donation->platformPercentage->percentage /100 ) * $donation->plan->amount));
            }else{
                $totalAmount += $donation->amount;
                $recievedAmount += ($donation->amount - (($donation->platformPercentage->percentage /100 ) * $donation->amount));
            }
        }   

        return [$recievedAmount , $totalAmount];
    }

    public function getRecentDonars($request){

        $query = Donation::query();

        $date = $request->date;
        $plan = $request->plan;

        $query->when(!auth()->user()->hasRole('admin') , function($query1){
            $query1->when(auth()->user()->hasRole('owner') , function($query2){
                $query2->whereHas('campaign' , function($query3){
                    $query3->where('user_id' , auth()->user()->id);
                });
            });

            $query1->when(auth()->user()->hasRole('fundraiser') || auth()->user()->hasRole('organization_admin') , function($query2){
                $query2->whereHas('campaign' , function($query3){
                    $query3->where('created_by' , auth()->user()->id);
                });
            });
        });

        $query->when(isset($date) && !is_null($date) && !empty($date), function($query1) use ($date){
            $query1->where('created_at' ,  $date);
        });

        $query->when(isset($plan) && !is_null($plan) && !empty($plan), function($query1)  use ($plan) {
            $query1->whereHas('donar' , function($query2) use ($plan) {
                $query2->whereHas('subscriptionPlans' , function($query3) use($plan) {
                    $query3->where('membership_subscribers.id' , $plan);
                });
            });
        });



        $donations = $query->with('donar' , 'plan')->orderBy('id' , 'desc')->paginate(10);

        return $donations;
    }

    public function totalDonationCount(){
        $query = Donation::query();

        $query->when( !auth()->user()->hasRole('admin') , function($query){

            $query->when(auth()->user()->hasRole('owner') , function($query){
                $query->whereHas('campaign' ,function($query){
                    $query->whereHas('user' , function($query1){
                        $query1->where('id' , auth()->user()->id);
                    });
                });
            });


            $query->when(auth()->user()->hasRole('fundraiser')  || auth()->user()->hasRole('organization_admin') , function($query){
                $query->whereHas('campaign' ,function($query){
                    $query->whereHas('creator' , function($query1){
                        $query1->where('id' , auth()->user()->id);
                    });
                });
            });

            
        });

        $totalDonation = $query->count();

        return $totalDonation;
    }

    public function getConnectedId($campaignId)
    {
       return  Campaign::with('user')->where('id' , $campaignId)->first()->user->stripe_connected_id;
    }

    public function getlatestDonars(){

        $query = Donation::query();

        $query->when( !auth()->user()->hasRole('admin') , function($query){

            $query->whereHas('campaign' , function($query){

                $query->when(auth()->user()->hasRole('owner') , function($query1){
                    $query1->where('user_id' , auth()->user()->id);
                });

                $query->when(auth()->user()->hasRole('fundraiser')  || auth()->user()->hasRole('organization_admin')  , function($query1){
                    $query1->where('created_by' , auth()->user()->id);
                });

            });
        });

        $donations =$query->with('campaign' , 'platformPercentage' , 'donar' , 'plan')
                            ->orderBy('id' , 'desc')
                            ->limit(10)
                            ->get();

        return $donations;
    }

    public function testCron()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $plans = PlanSubscriber::with('subscription' ,'subscriber' ,'plan.user' , 'campaign.user')
                                    ->where(DB::raw("Date(expiry_date)") , '<=' , $currentDate )
                                    ->where('status' , \AppConst::ACTIVE_PLAN)
                                    ->get();

        
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $platformPercentage = PlatformPercentage::first();
        foreach($plans as $plan){
            $selectedPlan = $plan->plan;
            $connectedId = $selectedPlan->user->stripe_connected_id;
            $option = ['stripe_account' => $connectedId];

            try{
                $previousPayment = $stripe->customers->allPaymentMethods($plan->subscription->customer_id, [] , $option);

                $chargeDetail = $stripe->paymentIntents->create([
                                        'amount' => $selectedPlan->amount * 100,
                                        'currency' => 'usd',
                                        'payment_method' => $previousPayment->data[0]->id,
                                        'customer' => $plan->subscription->customer_id,
                                        'confirm' => true,
                                        'description' => 'Plan payment',
                                        'automatic_payment_methods' => [
                                            'enabled' => true,
                                            'allow_redirects' => 'never',
                                        ],
                                    ], $option);


    
                $donation = new Donation;
                $donation->percentage_id = $platformPercentage->id;
                $donation->plan_id = $selectedPlan->id;
                $donation->campaign_id = $plan->campaign_id;
                $donation->donar_id = $plan->subscriber_id;
                $donation->status = \AppConst::DONATION_COMPLETED;
                $donation->payment_id = $chargeDetail->id;
                if($donation->save())
                {
                    $planDetail = PlanSubscriber::where('id' , $plan->id)->first();
                    $planInterval = $planDetail->interval;
                    $currentDate = \Carbon\Carbon::now();
                    switch($planInterval){
                        case(\AppConst::MONTHLY_INTERVAL):
                            $planDetail->interval = $currentDate->addMonth()->format('Y-m-d');
                        break;
                        case(\AppConst::QUARTERLY_INTERVAL):
                            $planDetail->interval = $currentDate->addMonth(3)->format('Y-m-d');
                        break;
                        case(\AppConst::ANNUALLY_INTERVAL):
                            $planDetail->interval = $currentDate->addYear(3)->format('Y-m-d');
                        break;
                    }

                    $planDetail->save();

                    dispatch(new MailingJob(\AppConst::DONATION_SUCCESS , $plan->subscriber->email , $plan->campaign->user->id));

                }

            }catch(\Exception $e){
                $donation = new Donation;
                $donation->percentage_id = $platformPercentage->id;
                $donation->plan_id = $selectedPlan->id;
                $donation->campaign_id = $plan->campaign_id;
                $donation->donar_id = $plan->subscriber_id;
                $donation->status = \AppConst::DONATION_FAILED;
                $donation->save();
                dispatch(new MailingJob(\AppConst::DONATION_REJECTED , $plan->subscriber->email , $plan->campaign->user->id));
            }
        }

    }




}