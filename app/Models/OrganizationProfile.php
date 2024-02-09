<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;

class OrganizationProfile extends Model
{
    use HasFactory;
    protected $table = "organization_profile";
    protected $primaryKey = "id";
    protected $fillable = ["user_id" , "name" , "phone" , "type" , "description" , "link" , "platform" , "logo_link" ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }

    public function organizationAdmin()
    {
        return $this->belongsToMany(User::class , 'organization_admin'  , 'organization_id' , 'user_id');
    }
}
