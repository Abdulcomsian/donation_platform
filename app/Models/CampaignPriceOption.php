<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignPriceOption extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'campaign_price_options';
    protected $primaryKey = 'id';
    protected $fillable = ['campaign_id' , 'price_option_id'];

}
