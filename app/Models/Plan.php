<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{ User };
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

    public function subscribers()
    {
        return $this->belongsToMany(User::class , 'plan_subscribers' , 'plan_id' , 'subscriber_id' )->withPivot('interval' , 'expiry_date' , 'status');
    }


}
