<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Campaign , PlatformPercentage , User , Plan};
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $fillable = [ 'percentage_id' , 'plan_id' , 'campaign_id' , 'donar_id'  , 'status' , 'amount' , 'payment_id'];

    public function campaign(){
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    } 

    public function platformPercentage(){
        return $this->belongsTo(PlatformPercentage::class , 'percentage_id' , 'id');
    }

    public function donar(){
        return $this->belongsTo(User::class , 'donar_id' , 'id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class , 'plan_id' , 'id');
    }


}
