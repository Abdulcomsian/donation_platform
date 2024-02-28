<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\AppConst;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use App\Models\{Address , MailchimpIntegration , Donation , EventTicket , OrganizationProfile , Mailing , MembershipPlan };
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , Billable , HasRoles , HasPermissions , SoftDeletes;

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
        'stripe_connected_id',
        'stripe_is_verified',
        'profile_image',
        'logo',
        'activation_status'
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
    
    public function campaigns()
    {
        return $this->hasMany(Campaign::class , 'user_id' , 'id');
    }

    public function address()
    {
        return $this->morphOne(Address::class , 'addressable');
    }

    public function mailchimp()
    {
        return $this->hasOne(MailchimpIntegration::class , 'user_id' , 'id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class , 'donar_id' , 'id');
    }

    public function organizationProfile()
    {
        return $this->hasOne(OrganizationProfile::class , 'user_id' , 'id');
    }

    public function ticket()
    {
        return $this->belongsToMany(EventTicket::class , 'user_ticket' , 'user_id' , 'ticket_id')->withPivot('quantity');
    }

    public function event()
    {
        return $this->hasMany(Event::class , 'user_id' , 'id');
    }

    public function plans()
    {
        return $this->belongsToMany(Plan::class , 'plan_subscribers' , 'subscriber_id' , 'plan_id' )->withPivot('interval' , 'expiry_date' , 'status');
    }

    public function customer()
    {
        return $this->hasMany(User::class , 'subscriber_id' , 'id' );
    }

    public function annuallyMembershipPlan()
    {
        return $this->hasMany(MembershipPlan::class , 'user_id' , 'id')->where('type' , AppConst::ANNUALLY_PLAN);
    }

    public function monthlyMembershipPlan()
    {
        return $this->hasMany(MembershipPlan::class , 'user_id' , 'id')->where('type' , AppConst::MONTHLY_PLAN);
    }

    public function subscriptionPlans()
    {
        return $this->belongsToMany(MembershipPlan::class , 'membership_subscribers' , 'member_id' , 'plan_id')->withPivot('subscription_id');
    }

    public function organizationAdmin()
    {
        return $this->belongsToMany(OrganizationProfile::class , 'organization_admin' , 'user_id' , 'organization_id');
    }
 
    public function donationSuccessMail()
    { 
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::DONATION_SUCCESS);
    }
    
    public function subscriptionSuccessMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::SUBSCRIPTION_SUCCESS);;
    }
    
    public function subscriptionFailedMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::SUBSCRIPTION_FAILED);;
    }
    
    public function donationRefundMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::DONATION_REFUND);;
    }
    
    public function subscriptionCanceledMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::DONATION_SUBSCRIPTION_CANCELED);;
    }
    
    public function membershipSubscriptionMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::NEW_MEMBERSHIP);;
    }
    
    public function membershipRenewelMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::MEMBERSHIP_RENEWEL_SUCCESS);;
    }
    
    public function membershipCanceledMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::MEMBERSHIP_CANCELED);;
    }
   
    public function membershipRenewelFailedMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::MEMBERSHIP_RENEWEL_FAILED);;
    }
   
    public function membershipRefundMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::MEMBERSHIP_REFUND);;
    }
   
    public function eventRegistrationMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::EVENT_REGISTRATION);;
    }
    
    public function eventCanceledMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::EVENT_CANCELED);;
    }
    
    public function eventTicketRefundMail()
    {
        return $this->hasOne(Mailing::class , 'user_id' , 'id')->where('type' , AppConst::EVENT_TICKET_REFUND);;
    }

    

    
}
