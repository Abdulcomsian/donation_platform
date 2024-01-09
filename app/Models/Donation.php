<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Campaign , PlatformPercentage };

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $fillable = ['name' , 'percentage_id' , 'campaign_id' , 'status' , 'amount' , 'stripe_id' , 'doner_email'];

    public function campaign(){
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    } 

    public function platformPercentage(){
        return $this->belongsTo(PlatformPercentage::class , 'percentage_id' , 'id');
    }
}
