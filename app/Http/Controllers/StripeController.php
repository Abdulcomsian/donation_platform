<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\{ Stripe , AccountLink , Account , SetupIntent };
use Stripe\Exception\CardException;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

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

    
   public function stripeHostedOnboarding(Request $request){
    try{

        $redirectUrl  = route('stripe.connect.callback');
    
        // $account =   Account::create(['type' => 'express']);

        $account = null;

        if(!auth()->user()->stripe_connected_id)
        {

            $account =   Account::create(['type' => 'custom' , 
                                            'capabilities' => [
                                                'card_payments' => ['requested' => true],
                                                'transfers' => ['requested' => true],
                                            ]
                                        ]);

            $user = User::where('id' , auth()->user()->id)->first();
            $user->stripe_connected_id = $account->id;
            $user->save();
            
            $account = $account->id;
        }else{

            $account = auth()->user()->stripe_connected_id;

        }

    
        if($account){
            
            $accountLink = AccountLink::create([
                    'account' => $account,
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
    $user = User::where('id' , auth()->user()->id)->first();
    if($account->charges_enabled){
        $user->stripe_is_verified = \AppConst::STRIPE_VERIFIED;
        $user->save();
        \Toastr::success('User Connected Successfully' , 'Success!');
        return redirect()->route('dashboard');
    }else{
        $user->stripe_is_verified = \AppConst::STRIPE_INCOMPLETE_DETAIL;
        $user->save();
        \Toastr::error('Incomplete Stripe Detail' , 'Error!' );
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

   public function createSetupIntent(Request $request)
   {    
        $validator = Validator::make($request->all() , [
            'connectedId' => 'string|required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }

        $setupIntent = SetupIntent::create(['usage' => 'on_session'] , ['stripe_account' =>  $request->connectedId]);


        return response()->json(['status' => true , 'clientSecret' => $setupIntent->client_secret]);
   }

}
