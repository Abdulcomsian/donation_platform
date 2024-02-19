<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{MembershipPlan , User};

class MembershipSubscriber extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'membership_subscribers';
    protected $primaryKey = 'id';
    protected $fillable = [ 'member_id', 'plan_id' , 'subscription_id'];

    public function plan(){
        return $this->belongsTo(MembershipPlan::class , 'plan_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

}
