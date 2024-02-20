<?php

namespace App\Http;

class AppConst{

    //reference table users
    public const OWNER = 1;
    public const FUNDRAISER = 2;
    public const ADMIN = 3;
    public const ORGANIZATION_ADMIN = 4;
    public const DONAR = 4;
    public const PENDING = 0; 
    public const ACTIVATED = 1;
    public const REJECTED = 2;
    public const STRIPE_VERIFIED = 1;
    public const STRIPE_INCOMPLETE_DETAIL = 2;

    //reference table campaings
    public const ACTIVE = 1;
    public const INACTIVE = 0;

    //reference table Donation
    public const DONATION_PENDING = 'pending';
    public const DONATION_PROCESSING = 'processing';
    public const DONATION_COMPLETED = 'completed';
    public const DONATION_REFUNDED = 'refunded';
    public const DONATION_FAILED = 'failed';

    //reference table event_tickets
    public const STOP = 0;
    public const CONTINUE = 1;


    //reference table mailing and also use for template email
    public const DONATION_SUCCESS = 0;
    public const SUBSCRIPTION_SUCCESS = 1;
    public const SUBSCRIPTION_FAILED = 2;
    public const DONATION_REFUND = 3;
    public const DONATION_SUBSCRIPTION_CANCELED = 4;
    public const NEW_MEMBERSHIP = 5;
    public const MEMBERSHIP_RENEWEL_SUCCESS = 6;
    public const MEMBERSHIP_CANCELED = 7;
    public const MEMBERSHIP_RENEWEL_FAILED = 8;
    public const MEMBERSHIP_REFUND = 9;
    public const EVENT_REGISTRATION = 10;
    public const EVENT_CANCELED = 11;
    public const EVENT_TICKET_REFUND = 12;



    //reference table membership_plan
    public const MONTHLY_PLAN = 1;
    public const ANNUALLY_PLAN = 2;

    
}