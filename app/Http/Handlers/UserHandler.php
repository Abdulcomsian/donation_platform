<?php

namespace App\Http\Handlers;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserHandler{

    public function latestMemberCount()
    {
        $query = User::query();

        $query->when(!auth()->user()->hasRole('admin') , function($query){
            $query->whereHas('donations' , function($query1){
                $query1->whereHas('campaign' , function($query2){
                    $query2->where('user_id' , auth()->user()->id);
                });
            });
        });
        $newMemebersCount = $query->where(DB::raw('created_at') , '>=' , now()->firstOfMonth())->count();


        return $newMemebersCount;
    }

    public function recurringDonarCount()
    {
        $query  = User::query();
                
        $query->whereHas('donations' , function($query){
            $query->when(!auth()->user()->hasRole('admin') , function($query1){
                $query1->whereHas('campaign' , function($query1){
                    $query1->where('user_id' , auth()->user()->id);
                });
            });
            $query->select('donar_id')
            ->groupBy('donar_id')
            ->havingRaw('COUNT(donar_id) > 1');
        });
        
        $recurringDonarCount = $query->count();
    
        return $recurringDonarCount;
    }


}