<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\{Address , MailchimpIntegration , Donation , EventTicket};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , Billable , HasRoles , HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted()
    {
        static::addGlobalScope('postDetails' , function(Builder $builder){
            $builder->with('address');
        });
    }
    
    public function campaigns(){
        return $this->hasMany(Campaign::class , 'user_id' , 'id');
    }

    public function address(){
        return $this->morphOne(Address::class , 'addressable');
    }

    public function mailchimp(){
        return $this->hasOne(MailchimpIntegration::class , 'user_id' , 'id');
    }

    public function donations(){
        return $this->hasMany(Donation::class , 'donar_id' , 'id');
    }

    public function ticket()
    {
        return $this->belongsToMany(EventTicket::class , 'user_ticket' , 'user_id' , 'ticket_id');
    }

}
