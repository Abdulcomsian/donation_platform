<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationAdmin extends Model
{
    use HasFactory , SoftDeletes;
    
    protected $table = "organization_admin";
    protected $primaryKey = "id";
    protected $fillable = ["organization_id" , "user_id"];

    
}
