<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{MembershipSubscriber};
use Carbon\Carbon;
use Stripe\StripeClient;

class MembershipSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:membership-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
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
