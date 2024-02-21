<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Donation , PriceOption , CampaignFrequency, User };
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory , SoftDeletes;
    
    protected $table = 'campaigns';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'created_by' , 'title' , 'excerpt' , 'description' , 'image' , 'recurring' , 'campaign_goal' , 'amount' , 'fee_recovery' , 'expiry_date', 'image' , 'status'];

    public function donations(){
        return $this->hasMany(Donation::class , 'campaign_id' , 'id');
    }

    public function priceOptions(){
        return $this->belongsToMany(PriceOption::class , 'campaign_price_options' , 'campaign_id' , 'price_option_id');
    }

    public function frequencies(){
        return $this->hasMany(CampaignFrequency::class , 'campaign_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function creator(){
        return $this->belongsTo(User::class , 'created_by' , 'id');
    }

}
