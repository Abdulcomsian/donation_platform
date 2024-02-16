<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserTicket extends Model
{
    use HasFactory , SoftDeletes;
    
    protected $table = 'user_ticket';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id' , 'ticket_id' , 'quantity' , 'stripe_id'];

  
}
