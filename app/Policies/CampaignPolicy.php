<?php

namespace App\Policies;
use App\Models\Campaign;

class CampaignPolicy
{


    public function view($user , $campaignId){

        if($user->hasRole('admin') || Campaign::where('id' , $campaignId)->first()->user_id == auth()->user()->id){
            return true;
        }

        abort(401);
    }
}
