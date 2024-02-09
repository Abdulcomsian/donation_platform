<?php 

namespace App\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventMail;

class Helper{

    public static function sendMail($eventType ,  $email)
    {
        Mail::to($email)->send(new EventMail($eventType));
    }

}