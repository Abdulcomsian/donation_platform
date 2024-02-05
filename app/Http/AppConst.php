<?php

namespace App\Http;

class AppConst{

    //reference table users
    public const NON_PROFIT_ORGANIZATION = 1;
    public const FUNDRAISER = 2;
    public const ADMIN = 3;
    public const DONAR = 4;
    public const PENDING = 0; 
    public const ACTIVATED = 1;
    public const REJECTED = 2;

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

    

    
}