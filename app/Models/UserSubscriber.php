<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSubscriber extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'user_subscribers';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id' , 'subscriber_id' , 'customer_id'];

    public function subscriber()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'subscriber_id' , 'id');
    }

}
