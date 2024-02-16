<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanInterval extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'plan_intervals';
    protected $primaryKey = 'id';
    protected $fillable = ['plan_id' , 'interval' , 'stripe_plan_id'];

    public function plan()
    {
        $this->belongsTo(Plan::class , 'plan_id' , 'id');
    }
}
