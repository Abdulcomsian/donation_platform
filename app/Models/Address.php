<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'address';
    protected $primaryKey = 'id';
    protected $fillable = ['addressable_id' , 'addressable_type' , 'country_id' , 'city_id' , 'street'];

    public function addressable(){
        return $this->morphTo();
    }
}
