<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MailchimpIntegration extends Model
{
    use HasFactory;

    protected $table = 'mailchimp_integrations';
    protected $primaryKey = 'id';
    protected $fillable = [ 'user_id' , 'api_key' , 'list_id'];

    public function user(){
        return $this->belongTo(User::class , 'user_id' , 'id');
    }

}
