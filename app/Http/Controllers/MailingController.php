<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Handlers\{MailingHandler};

class MailingController extends Controller
{
    protected $mailingHandler;
    
    function __construct(MailingHandler $mailHandler)
    {
        $this->mailingHandler = $mailHandler;
    }


    public function updateUserMail(Request $request)
    {
        $validator = Validator::make($request->all() , [
            'type' => 'required|numeric',
            'description' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => implode( ",", $validator->messages()->all())]);
        }
                
        try{

            $response = $this->mailingHandler->updateUserMail($request);
            return response()->json($response);

        }catch(\Exception $e){
            return response()->json(['status' => false , 'msg' => 'Something Went Wrong' , 'error' => $e->getMessage()]);
        }
    }

    public function donationSuccess()
    {
    return view('mail.donation_success');       
    }

    public function subscriptionSuccess()
    {
        return view('mail.subscription_success');
    }

    public function subscriptionFailed()
    {
        return view('mail.subscription_failed');
    }

    public function donationRefund()
    {
        return view('mail.donation_refund');
    }

    public function donationSubscriptionCanceled()
    {
        return view('mail.subscription_canceled');
    }

    public function newMembership()
    {
        return view('mail.create_membership');
    }

    public function membershipRenewalSuccess()
    {
        return view('mail.membership_renewel');
    }

    public function membershipCanceled()
    {
        return view('mail.membership_canceled');
    }

    public function membershipRenewalFailed()
    {
        return view('mail.membership_renewel_failed');
    }

    public function membershipRefund()
    {
        return view('mail.membership_refund');
    }

    public function eventRegistration()
    {
        return view('mail.event_registration');
    }

    public function eventCanceled()
    {
        return view('mail.event_canceled');
    }

    public function eventTicketRefund()
    {
        return view('mail.event_ticket_refund');
    }




    
}
