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
        $plans = PlanSubscriber::with('subscription' ,'subscriber' ,'plan.user' , 'campaign.user')->where(DB::raw("Date(expiry_date)") , $currentDate )->get();
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $platformPercentage = PlatformPercentage::first();
        foreach($plans as $plan){
            $selectedPlan = $plan->plan;
            $connectedId = $selectedPlan->user->stripe_connected_id;
            $option = ['stripe_connected_id' => $connectedId];

            try{
                $chargeDetail = $stripe->charges->create([
                    'amount' => $selectedPlan->amount * 100,
                    'currency' => 'usd',
                    'customer' => $plan->customer_id
                ] , $option);
    
                $donation = new Donation;
                $donation->percentage_id = $platformPercentage->id;
                $donation->plan_id = $selectedPlan->id;
                $donation->campaign_id = $plan->campaign_id;
                $donation->donar_id = $plan->subscriber_id;
                $donation->status = \AppConst::DONATION_COMPLETED;
                $donation->payment_id = $chargeDetail->id;
                $donation->save();
                dispatch(new MailingJob(\AppConst::DONATION_SUCCESS , $plan->subscriber->email , $plan->campaign->user->id));

            }catch(\Exception $e){

                $donation = new Donation;
                $donation->percentage_id = $platformPercentage->id;
                $donation->plan_id = $selectedPlan->id;
                $donation->campaign_id = $plan->campaign_id;
                $donation->donar_id = $plan->subscriber_id;
                $donation->status = \AppConst::DONATION_FAILED;
                $donation->payment_id = $chargeDetail->id;
                $donation->save();
                dispatch(new MailingJob(\AppConst::DONATION_REJECTED , $plan->subscriber->email , $plan->campaign->user->id));
                
            }
            

        }
    }
}
