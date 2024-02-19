<?php 

namespace App\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventMail;
use App\Models\OrganizationProfile;
class Helper{

    public static function sendMail($eventType ,  $email , $userId)
    {
        Mail::to($email)->send(new EventMail($eventType , $userId));
    }

    public static function getOrganizationOwnerId()
    {
        if(auth()->user()->hasRole('owner')){
            $organizationProfile = OrganizationProfile::with('user')->where('user_id', auth()->user()->id)->first();
            return $organizationProfile->user->id;
        }else{
            $organizationProfile = OrganizationProfile::whereHas('organizationAdmin' , function($childQuery){
                                        $childQuery->where('user_id' , auth()->user()->id);
                                    })->with('user')->first();
            return $organizationProfile->user->id;
        }


       
    }

}