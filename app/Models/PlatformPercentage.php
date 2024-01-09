<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformPercentage extends Model
{
    use HasFactory;

    protected $table = 'platform_percentage';
    protected $primaryKey = 'id';
    protected $fillable = ['percentage'];

    public static function latestPercentage(){
        return Self::orderBy('id' , 'desc')->first();
    }

}
