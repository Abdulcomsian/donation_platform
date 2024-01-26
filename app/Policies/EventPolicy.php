<?php

namespace App\Policies;

use App\Models\Event;

class EventPolicy
{
    public function view($user , $eventId){

        if($user->hasRole('admin') || Event::where('id' , $eventId)->first()->user_id == auth()->user()->id){
            return true;
        }

        abort(401);
    }
}
