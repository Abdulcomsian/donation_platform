<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{MembershipPlan , User , UserSubscriber};

class MembershipSubscriber extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'membership_subscribers';
    protected $primaryKey = 'id';
    protected $fillable = [ 'member_id', 'plan_id' , 'subscription_id' , 'expiry_date' , 'status'];

    public function plan(){
        return $this->belongsTo(MembershipPlan::class , 'plan_id' , 'id');
    }

    public function member(){
        return $this->belongsTo(User::class , 'member_id' , 'id');
    }

    public function subscription(){
        return $this->belongsTo(UserSubscriber::class , 'subscription_id' , 'id' );
    }

}
