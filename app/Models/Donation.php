<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Campaign , PlatformPercentage , User ,PriceOption};

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    protected $primaryKey = 'id';
    protected $fillable = [ 'percentage_id' , 'campaign_id' , 'donar_id' , 'price_option_id' , 'status' , 'amount'];

    public function campaign(){
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    } 

    public function platformPercentage(){
        return $this->belongsTo(PlatformPercentage::class , 'percentage_id' , 'id');
    }

    public function donar(){
        return $this->belongsTo(User::class , 'donar_id' , 'id');
    }

    public function price(){
        return $this->belongsTo(PriceOption::class , 'price_option_id' , 'id');
    }

}
