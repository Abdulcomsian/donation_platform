<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PlanSubscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use App\Models\{Donation , PlatformPercentage};
use App\Mail\EventMail;

class PlanSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:plan-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For Renew Subscription';

    /**
     * Execute the console command.
     */
    public function handle()
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
