<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{User};

class MembershipPlan extends Model
{
    use HasFactory , SoftDeletes;
    
    protected $table = 'membership_plan';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'created_by' , 'name', 'amount' ,'type'];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class , 'membership_subscribers' , 'plan_id' , 'member_id')->withPivot('subscription_id');
    }



}
