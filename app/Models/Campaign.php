<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ Donation , PriceOption };

class Campaign extends Model
{
    use HasFactory;
    protected $table = 'campaigns';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'title' , 'excerpt' , 'description' , 'image' , 'frequency' , 'recurring' , 'campaign_goal' , 'amount' , 'fee_recovery' , 'date', 'image'];

    public function donations(){
        return $this->hasMany(Donation::class , 'campaign_id' , 'id');
    }

    public function priceOptions(){
        return $this->hasMany(PriceOption::class , 'campaign_id' , 'id');
    }
}
