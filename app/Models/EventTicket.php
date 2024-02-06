<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Event , User};

class EventTicket extends Model
{
    use HasFactory, SoftDeletes;
     
    protected $table = 'event_tickets';
    protected $primaryKey = 'id';
    protected $fillable = [ 'event_id' , 'generated_id' , 'name' ,'description', 'quantity', 'is_free', 'price' ];


    public function event(){
        return $this->belongsTo(Event::class , 'event_id' , 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_ticket' , 'ticket_id' , 'user_id')->withPivot('quantity');
    }
}
