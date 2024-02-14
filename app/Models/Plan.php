<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User , PlanInterval};
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id' , 'amount' , 'name'];

    public function user()
    {
        return  $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function planInterval()
    {
        return $this->hasMany(PlanInterval::class , 'plan_id' , 'id');
    }

    public function monthlyInterval()
    {
        return $this->hasOne(PlanInterval::class , 'plan_id' , 'id')->where('interval' , 'month');
    }

    public function quarterlyInterval()
    {
        return $this->hasOne(PlanInterval::class , 'plan_id' , 'id')->where('interval' , 'quarter');
    }

    public function yearlyInterval()
    {
        return $this->hasOne(PlanInterval::class , 'plan_id' , 'id')->where('interval' , 'year');
    }


}
