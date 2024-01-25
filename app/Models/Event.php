<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Country , EventCategory , EventFrequency , EventTicket};

class Event extends Model
{
    use HasFactory, SoftDeletes;
     
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [ 'country_id' ,'category_id', 'frequency_id', 'title' ,'description', 'image' , 'date' , 'time', 'venue', 'organizer', 'featured'];


    public function country(){
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }

    public function category(){
        return $this->belongsTo(EventCategory::class , 'category_id' , 'id');
    }

    public function frequency(){
        return $this->belongsTo(EventFrequency::class , 'frequency_id' , 'id');
    }

    public function ticket(){
        return $this->hasMany(EventTicket::class , 'event_id' , 'id');
    }


}
