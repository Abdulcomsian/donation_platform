<?php

namespace App\Http\Handlers;

use App\Http\AppConst;
use App\Models\{MembershipPlan, MembershipSubscriber, User };
use Stripe\{Stripe , Product , Price , StripeClient , SetupIntent};
use Illuminate\Support\Facades\Crypt;
use App\Jobs\MailingJob;

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
                'user_id' => $userId,
                'created_by' => auth()->user()->id,
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
        $planId = $request->plan;
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $membershipPlan = MembershipPlan::with('user')->where('id' , $planId)->first();
         
        $options = ['stripe_account' => $membershipPlan->user->stripe_connected_id];


        $customer = $stripe->customers->create([
            'email' => $request->email,
            'description' => 'membership creating for donation platform'
        ], $options);

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
                'member_id' => $user->id,
                'plan_id' => $membershipPlan->id,
                'subscription_id' => $subscription->id
            ]);
            
            dispatch(new MailingJob(\AppConst::NEW_MEMBERSHIP , $user->email , $user->id));

            return ['status' => true , 'msg' => 'Member added successfully'];
        }

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

        $members = $query->with('user')->get();

        return $members;
    }
} 