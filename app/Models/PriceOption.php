<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Campaign;

class PriceOption extends Model
{
    use HasFactory;
    
    protected $table = 'price_options';
    protected $primaryKey = 'id';
    protected $fillable = ['amount'];

    public function campaign(){
        return $this->belongTo(Campaign::class , 'campaign_id' , 'id');
    }



}
