<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{ Plan , User , UserSubscriber, Campaign};

class PlanSubscriber extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'plan_subscribers';
    protected $primaryKey = 'id';
    protected $fillable = ['plan_id' , 'subscriber_id' , 'campaign_id' , 'subscription_id' , 'interval' , 'expiry_date' , 'status'];

    public function plan(){
        return $this->belongsTo(Plan::class, 'plan_id' , 'id');
    }

    public function subscriber(){
        return $this->belongsTo(User::class, 'subscriber_id' , 'id');
    }

    public function subscription(){
        return $this->belongsTo(UserSubscriber::class , 'subscription_id' , 'id');
    }

    public function campaign(){
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    }
}
