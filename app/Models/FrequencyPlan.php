<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CampaignFrequency;

class FrequencyPlan extends Model
{
    use HasFactory;
    protected $table = 'frequency_plans';
    protected $primaryKey = 'id';
    protected $fillable = ['frequency_id', 'plan_id', 'plan_title'];

    public function frequency(){
        return $this->belongsTo(CampaignFrequency::class , 'frequency_id' , 'id');
    }

}
