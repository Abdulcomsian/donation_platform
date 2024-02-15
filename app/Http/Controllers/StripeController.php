<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\{ Stripe , AccountLink , OAuth , Account };
use Stripe\Exception\CardException;
use App\Models\User;
class StripeController extends Controller
{
    function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));        
    }

    public function connectStripe(){
        $user = auth()->user();

        try{
            if(!$user->hasStripeId())
            {
                $user->createAsStripeCustomer();
                \Toastr::success('User Connected Successfully' , 'Success!');
                return redirect()->back();
            }else{
                \Toastr::error('User Already Have Stripe Account' , 'Error!' );
                return redirect()->back()->with(['success' => false , 'msg' => 'User Already Have Stripe Account']);
            }
        }catch(CardException $e){
            \Toastr::error('Something Went Wrong' , 'Error!' );
            \Toastr::error($e->getMessage() , 'Error!' );
            return redirect()->back();
        }

    }


    public function removeConnectedAccount(){
        try{
            $user = auth()->user();
            if($user->hasStripeId()){
                $user->deleteStripeCustomer();
                \Toastr::success('User Remove from stripe successfully' , 'Success!');
                return redirect()->back();
            }else{
                \Toastr::error('Not A Stripe Customer' , 'Error!' );
                return redirect()->back();
            }
        }catch(\Exception $e){
            \Toastr::error('Something Went Wrong' , 'Error!' );
            \Toastr::error($e->getMessage() , 'Error!' );
            return redirect()->back();
        }
        
    }

    
   public function stripeHostedOnboarding(){
    try{

        $redirectUrl  = route('dashboard');
    
        // $account =   Account::create(['type' => 'express']);

        $account =   Account::create(['type' => 'custom' , 
                                        'capabilities' => [
                                            'card_payments' => ['requested' => true],
                                            'transfers' => ['requested' => true],
                                        ]
                                    ]);
    
        if($account){
            $user = User::where('id' , auth()->user()->id)->first();
            $user->stripe_connected_id = $account->id;
            $user->save();
            $accountLink = AccountLink::create([
                    'account' => $account->id,
                    'refresh_url' => route('stripe.hosted.onboarding'),
                    'return_url' => $redirectUrl, 
                    'type' => 'account_onboarding',
            ]);

            return redirect($accountLink->url);
        }
    
    
    }catch(\Exception $e){
        \Toastr::error('Something Went Wrong' , 'Error!' );
        \Toastr::error($e->getMessage() , 'Error!' );
        return redirect()->back();
    }
    
   }

   public function handleConnectCallback(){
   
    $account = Account::retrieve(auth()->user()->stripe_connected_id);
    // dd($account , $account->payouts_enabled , $account->charges_enabled );

    // $account->payouts_enabled && $account->charges_enabled
    if($account->charges_enabled){
        $user = User::where('id' , auth()->user()->id)->first();
        $user->stripe_is_verified = 1;
        $user->save();
        \Toastr::success('User Connected Successfully' , 'Success!');
        return redirect()->route('dashboard');
    }else{
        \Toastr::error('Something Went Wrong' , 'Error!' );
        return redirect()->back();
    }

   }


   public function removeStripeConnectedAccount()
   {
        $user = User::where('id' , auth()->user()->id)->first();
        $user->stripe_connected_id = null;
        $user->stripe_is_verified = 0;
        $user->save();
        \Toastr::success('Connected Account Removed Successfully' , 'Success!');
        return redirect()->route('dashboard');
   }

}
