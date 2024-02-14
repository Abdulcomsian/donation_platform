<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{MembershipPlan, MembershipSubscriber, User};
use Stripe\{Stripe , Product , Price , StripeClient};

class MembershipHandler{

    public function createMembershipPlan($request)
    {
        $plans = $request->plan;
        // $type = $request->type;
        // $amount = $request->amount;
        // $name = $request->name;

        //check number of current plans
        $user = User::with('monthlyMembershipPlan' , 'annuallyMembershipPlan')->where('id' , auth()->user()->id)->first();

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
            $product = Product::create( 
                ['name' => $plan['name']],
                ['stripe_account' => auth()->user()->stripe_connected_id]
            );

            $price = Price::create(
                [
                            'product' => $product->id,
                            'unit_amount' => $plan['amount'] * 100,
                            'currency' => 'usd',
                            'recurring' => [
                                'interval' => $plan['type'] == \AppConst::MONTHLY_PLAN ? 'month' : 'year'
                            ]
                ], ['stripe_account' => auth()->user()->stripe_connected_id]);

            $membershipPlans[] = [
                'type' => $plan['type'],
                'amount' => $plan['amount'],
                'name' => $plan['name'],
                'user_id' => auth()->user()->id,
                'plan_id' => $price->id
            ];
        }


        MembershipPlan::insert($membershipPlans);
        
        return ["status" => true , "msg" => "Membership Plan Created Successfully"];

    }

    public function membershipPlanList()
    {
        $monthlyPlans =  MembershipPlan::where('user_id' , auth()->user()->id)->where('type' , AppConst::MONTHLY_PLAN)->get();
        $annuallyPlans = MembershipPlan::where('user_id' , auth()->user()->id)->where('type' , AppConst::ANNUALLY_PLAN)->get();
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
        $planId = $request->planId;
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $membershipPlan = MembershipPlan::with('user')->where('id' , $planId)->first();
         
        $options = ['stripe_account' => $membershipPlan->user->stripe_connected_id];

        $customer = $stripe->customers->create([
            'email' => $request->email,
            'description' => 'membership creating for donation platform'
        ]);

        $stripe->paymentMethods->attach(
                    $request->payment_method,
                    ['customer' => $customer->id],
                    $options
                );

        $stripeCustomer = $stripe->customers->update(
                    $customer->id , 
                    ['invoice_settings' => 
                        ["default_payment_method" =>  $request->payment_method],
                    ],  
                    $options
                );

        $subscription = $stripe->subscriptions->create(
                    [
                      'customer' => $stripeCustomer->id,
                      'items' => [['price' => $membershipPlan->plan_id]],
                    ],
                    $options
                  );

        
        if($subscription)
        {
            $user = $this->createPlanMember($request);
            MembershipSubscriber::create([
                'user_id' => $user->id,
                'plan_id' => $membershipPlan->id,
                'subscription_id' => $subscription->id
            ]);
        }

    }

    public function createPlanMember($request)
    {
        $user = User::where('email' , $request->email)->first();

        if(!$user){
            $user = User::create([
                'email' => $request->email
            ]);
        }

        if(!$user->hasRole('membership_subscriber'))
        {
            $user->assignRole('membership_subscriber');
        }

        return $user;
    }
} 