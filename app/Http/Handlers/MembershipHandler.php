<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{MembershipPlan, MembershipSubscriber, User, UserSubscriber};
use Stripe\{Stripe , Product , Price , StripeClient , SetupIntent};
use Illuminate\Support\Facades\Crypt;
use App\Jobs\MailingJob;
use Carbon\Carbon;
use Stripe\Issuing\Card;

class MembershipHandler{

    public function createMembershipPlan($request)
    {
        $plans = $request->plans;
        $type = $request->type;
        $userId = \Helper::getOrganizationOwnerId();
        
        $user = User::with('monthlyMembershipPlan' , 'annuallyMembershipPlan')->where('id' , $userId)->first();

        if($type == \AppConst::MONTHLY_PLAN && $user->monthlyMembershipPlan->count() == 3)
        {
            return ["status" => false , "msg" => "Maximum monthly membership plan limit reached"];
        }

        if($type == \AppConst::ANNUALLY_PLAN && $user->annuallyMembershipPlan->count() == 3)
        {
            return ["status" => false , "msg" => "Maximum yearly membership plan limit reached"];
        }


        Stripe::setApiKey(env('STRIPE_SECRET'));

        $membershipPlans = [];

        foreach($plans as $plan)
        {
            // $product = Product::create( 
            //     ['name' => $plan['name']],
            //     ['stripe_account' => auth()->user()->stripe_connected_id]
            // );

            // $price = Price::create(
            //     [
            //                 'product' => $product->id,
            //                 'unit_amount' => $plan['amount'] * 100,
            //                 'currency' => 'usd',
            //                 'recurring' => [
            //                     'interval' => $plan['type'] == \AppConst::MONTHLY_PLAN ? 'month' : 'year'
            //                 ]
            //     ], ['stripe_account' => auth()->user()->stripe_connected_id]);

            $membershipPlans[] = [
                'type' => $plan['type'],
                'amount' => $plan['amount'],
                'name' => $plan['name'],
                'user_id' => $userId,
                'created_by' => auth()->user()->id,
            ];
        }


        MembershipPlan::insert($membershipPlans);
        
        return ["status" => true , "msg" => "Membership Plan Created Successfully"];

    }

    public function membershipPlanList()
    {
        $userId = \Helper::getOrganizationOwnerId();
        $monthlyPlans =  MembershipPlan::where('user_id' , $userId)->where('type' , AppConst::MONTHLY_PLAN)->get();
        $annuallyPlans = MembershipPlan::where('user_id' , $userId)->where('type' , AppConst::ANNUALLY_PLAN)->get();
        return [$monthlyPlans , $annuallyPlans];
    }


    public function deleteMembershipPlan($request)
    {
        $planId = $request->planId;

        MembershipPlan::where('id' , $planId)->delete();

        return ['status' => true , 'msg' => 'Plan deleted successfully'];
    }

    public function subscribeUserInPlan($request)
    {
        $planId = $request->plan;
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $membershipPlan = MembershipPlan::with('user')->where('id' , $planId)->first();
         
        $options = ['stripe_account' => $membershipPlan->user->stripe_connected_id];

        $customer = $this->getCustomerDetail($request , $stripe , $options);
        
        $user = $this->createPlanMember($request);

        //create user as connected_customer if not already a connected customer
        $userSubscriber = UserSubscriber::where('user_id' , $membershipPlan->user->id)
                                          ->where('subscriber_id' , $user->id)
                                          ->first();

        if(!$userSubscriber)
        {
            $userSubscriber = UserSubscriber::create([
                                'user_id' => $membershipPlan->user->id,
                                'subscriber_id' => $user->id,
                                'customer_id' => $customer->id
                            ]);
        }

        try{
            $stripe->paymentMethods->attach(
                $request->payment_method,
                ['customer' => $customer->id],
                $options
            );
    
            
            //adding payment
            $paymentIntent = $stripe->paymentIntents->create([
                                    'amount' => $membershipPlan->amount * 100,
                                    'currency' => 'usd',
                                    'payment_method' => $request->payment_method,
                                    'customer' => $customer->id,
                                    'confirm' => true,
                                    'description' => 'Membership plan payment',
                                    'automatic_payment_methods' => [
                                    'enabled' => true,
                                    'allow_redirects' => 'never',
                                    ],
                                ], $options);
            
            if($paymentIntent)
            {
                $membershipSubscription = new MembershipSubscriber;
                $currentDate = Carbon::now();
                $membershipSubscription->expiry_date = $membershipPlan->type == 1 ? $currentDate->addMonth(1)->format('Y-m-d') :  $currentDate->addYear(1)->format('Y-m-d');
                $membershipSubscription->status = \AppConst::ACTIVE_PLAN;
                $membershipSubscription->member_id = $user->id;
                $membershipSubscription->plan_id = $membershipPlan->id;
                $membershipSubscription->subscription_id = $userSubscriber->id;
                $membershipSubscription->save();
                dispatch(new MailingJob(\AppConst::NEW_MEMBERSHIP , $user->email , $user->id));
                return ['status' => true , 'msg' => 'Membership Created Successfully'];
            }else{
                return ['status' => false , 'msg' => 'Something Went Wrong'];
            }

        }catch(\Exception $e){
            return ['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()];
        }


        // dd($paymentIntent);
        
        

        // $customer = $stripe->customers->create([
        //     'email' => $request->email,
        //     'description' => 'membership creating for donation platform'
        // ], $options);

        // $stripe->paymentMethods->attach(
        //             $request->payment_method,
        //             ['customer' => $customer->id],
        //             $options
        //         );

        // $stripeCustomer = $stripe->customers->update(
        //             $customer->id , 
        //             ['invoice_settings' => 
        //                 ["default_payment_method" =>  $request->payment_method],
        //             ],  
        //             $options
        //         );

        // $subscription = $stripe->subscriptions->create(
        //             [
        //               'customer' => $stripeCustomer->id,
        //               'items' => [['price' => $membershipPlan->plan_id]],
        //             ],
        //             $options
        //           );

        
        // if($subscription)
        // {
           
        //     MembershipSubscriber::create([
        //         'member_id' => $user->id,
        //         'plan_id' => $membershipPlan->id,
        //         'subscription_id' => $subscription->id
        //     ]);
            
        //     dispatch(new MailingJob(\AppConst::NEW_MEMBERSHIP , $user->email , $user->id));

        //     return ['status' => true , 'msg' => 'Member added successfully'];
        // }

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
                [ 'email' => $request->email, 'description' => 'membership connected account customer'],
                $options
            );

        }else{
            $customer = $findCustomer->data[0];
        }

        return $customer;
    }

    public function createPlanMember($request)
    {
        $user = User::where('email' , $request->email)->first();

        if(!$user){
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email
            ]);

            
        }

        if(!$user->hasRole('membership_subscriber'))
        {
            $user->assignRole('membership_subscriber');
        }

       
        return $user;
    }

    public function getMembershipPlanList($request)
    {
        $id = Crypt::decrypt($request->id);
        $membershipPlans = User::with('monthlyMembershipPlan' , 'annuallyMembershipPlan')->where('id' , $id)->first();
        return $membershipPlans;
    }

    public function createSetupIntent($connectedAccountId)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $setupIntent = SetupIntent::create(['usage' => 'on_session'] , ['stripe_account' => $connectedAccountId]);
        return $setupIntent;
    }

    public function getSubscribeMembers()
    {
        
        $query = MembershipSubscriber::query();
        
        $query->when(!auth()->user()->hasRole('admin') , function($query1){
            $userId = \Helper::getOrganizationOwnerId();
            $query1->whereHas('plan' , function($query2) use($userId){
                $query2->where('user_id' , $userId);
            });
        });

        $members = $query->with('member')->get();

        return $members;
    }

    public function getOrganizationPlans($request)
    {
        $id = Crypt::decrypt($request->id);

        $user = User::with('monthlyMembershipPlan' , 'annuallyMembershipPlan')->where('id' , $id)->first();

        return $user;
    }

    public function testCron()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $currentDate = Carbon::now();
        $subscriptionPlans = MembershipSubscriber::with('plan.user' ,'member' ,'subscription')
                                                ->where(\DB::raw('DATE(expiry_date)') , '<=' , $currentDate->format('Y-m-d'))
                                                ->where('status' , \AppConst::ACTIVE_PLAN)
                                                ->get();

        foreach($subscriptionPlans as $subscriptionPlan)
        {
            $selectedPlan = $subscriptionPlan->plan;
            $connectedId = $subscriptionPlan->plan->user->stripe_connected_id;
            $option = ['stripe_account' => $connectedId];

            // try{
                $previousPayment = $stripe->customers->allPaymentMethods($subscriptionPlan->subscription->customer_id, [] , $option);
                
                $chargeDetail = $stripe->paymentIntents->create([
                                        'amount' => $selectedPlan->amount * 100,
                                        'currency' => 'usd',
                                        'payment_method' => $previousPayment->data[0]->id,
                                        'customer' => $subscriptionPlan->subscription->customer_id,
                                        'confirm' => true,
                                        'description' => 'Plan payment',
                                        'automatic_payment_methods' => [
                                            'enabled' => true,
                                            'allow_redirects' => 'never',
                                        ],
                                    ], $option);
                dd($chargeDetail);
                $today = Carbon::now();
                if($chargeDetail->status == 'succeeded')
                {
                    $expiryDate = $selectedPlan->type == \AppConst::MONTHLY_PLAN ? $today->addMonth(1)->format('Y-m-d') : $today->addYear(1)->format('Y-m-d');  
                    MembershipSubscriber::where('id' , $subscriptionPlan->id)
                                          ->update(['expiry_date' => $expiryDate]);
                } else{
                    \Log::info("Somthing went wrong while renewal a membership plan with id: $subscriptionPlan->id");
                }
        }
    }

} 