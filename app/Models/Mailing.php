<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Mailing extends Model
{
    use HasFactory;

    use HasFactory , SoftDeletes;
    
    protected $table = 'mailing';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'html_content' , 'type'];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

}
