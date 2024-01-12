<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Donation , PriceOption , CampaignFrequency };

class Campaign extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'title' , 'excerpt' , 'description' , 'image' , 'recurring' , 'campaign_goal' , 'amount' , 'fee_recovery' , 'date', 'image'];

    public function donations(){
        return $this->hasMany(Donation::class , 'campaign_id' , 'id');
    }

    public function priceOptions(){
        return $this->hasMany(PriceOption::class , 'campaign_id' , 'id');
    }

    public function frequency(){
        return $this->hasMany(CampaignFrequency::class , 'campaign_id' , 'id');
    }
}
