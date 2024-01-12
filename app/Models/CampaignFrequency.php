<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Campaign , FrequencyPlan};

class CampaignFrequency extends Model
{
    use HasFactory;
    
    protected $table = 'campaign_frequency';
    protected $primaryKey = 'id';
    protected $fillable = ['campaign_id', 'type'];

    public function campaigns(){
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    }

    public function plan(){
        return $this->hasOne(FrequencyPlan::class , 'frequency_id' , 'id');
    }
}
