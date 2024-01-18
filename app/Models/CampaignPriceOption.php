<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignPriceOption extends Model
{
    use HasFactory;

    protected $table = 'campaign_price_options';
    protected $primaryKey = 'id';
    protected $fillable = ['campaign_id' , 'price_option_id'];

}
