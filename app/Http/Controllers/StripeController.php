<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\{ Stripe };
use Stripe\Exception\CardException;

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
                $user->createAsStripeCustomer([ 'name' =>'talha nafees' , 'email' => 'talfanafees@gmail.com']);
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

    // public function redirectCallback(Request $request)
    // {
    //     $user = auth()->user();
    //     $code = $request->code;
    //     $user->connectStripeAccount($code);
    //     dd("connected");
    //     return redirect()->route('dashboard')->with(['success'=> 'Stripe account connected successfully.']);
    // }

    public function addDonation(Request $request){

    }
}
