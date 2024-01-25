<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventFrequency extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'event_frequency';
    protected $primaryKey = 'id';
    protected $fillable = [ 'title'];

    public function event(){
        return $this->hasMany(Event::class , 'frequency_id' , 'id');
    } 

    
}
