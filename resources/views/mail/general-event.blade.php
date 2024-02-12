<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
                
    @php
        $content = null;
        switch($eventType){
            case \AppConst::DONATION_SUCCESS:
                $content = $user->donationSuccessMail ? $user->donationSuccessMail->html_content : view('mail.donation_success' , ['user' => $user])->render(); 
            break;
            case \AppConst::SUBSCRIPTION_SUCCESS:
                $content = $user->subscriptionSuccessMail ? $user->subscriptionSuccessMail->html_content : view('mail.subscription_success' , ['user' => $user])->render();
            break;
            case \AppConst::SUBSCRIPTION_FAILED:
                $content = $user->subscriptionFailedMail ? $user->subscriptionFailedMail->html_content : view('mail.subscription_failed' , ['user' => $user])->render();
            break;
            case \AppConst::DONATION_REFUND:
                $content = $user->donationRefundMail ? $user->donationRefundMail->html_content : view('mail.donation_refund' , ['user' => $user])->render();
            break;
            case \AppConst::DONATION_SUBSCRIPTION_CANCELED:
                $content = $user->subscriptionCanceledMail ? $user->subscriptionCanceledMail->html_content : view('mail.subscription_canceled' , ['user' => $user])->render();
            break;
            case \AppConst::NEW_MEMBERSHIP:
                $content = $user->membershipSubscriptionMail ? $user->membershipSubscriptionMail->html_content : view('mail.create_membership' , ['user' => $user])->render();
            break;
            case \AppConst::MEMBERSHIP_RENEWEL_SUCCESS:
                $content = $user->membershipRenewelMail ? $user->membershipRenewelMail->html_content : view('mail.membership_renewel' , ['user' => $user])->render();
            break;
            case \AppConst::MEMBERSHIP_CANCELED:
                $content = $user->membershipCanceledMail ? $user->membershipCanceledMail->html_content : view('mail.membership_canceled' , ['user' => $user])->render();
            break;
            case \AppConst::MEMBERSHIP_RENEWEL_FAILED:
                $content = $user->membershipRenewelFailedMail ? $user->membershipRenewelFailedMail->html_content : view('mail.membership_renewel_failed' , ['user' => $user])->render();
            break;
            case \AppConst::MEMBERSHIP_REFUND:
                $content = $user->membershipRefundMail ? $user->membershipRefundMail->html_content : view('mail.membership_refund' , ['user' => $user])->render();
            break;
            case \AppConst::EVENT_REGISTRATION:
                $content = $user->eventRegistrationMail ? $user->eventRegistrationMail->html_content : view('mail.event_registration' , ['user' => $user])->render();
            break;
            case \AppConst::EVENT_CANCELED:
                $content = $user->eventCanceledMail ? $user->eventCanceledMail->html_content : view('mail.event_canceled' , ['user' => $user])->render();
            break;
            case \AppConst::EVENT_TICKET_REFUND:
                $content = $user->eventTicketRefundMail ? $user->eventTicketRefundMail->html_content : view('mail.event_ticket_refund' , ['user' => $user])->render();
            break;

        }
    @endphp
    {!! $content !!}
</body>
</html>