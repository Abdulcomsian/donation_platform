<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembershipSubscriber extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'membership_subscribers';
    protected $primaryKey = 'id';
    protected $fillable = [ 'user_id', 'plan_id' , 'subscription_id'];

}
