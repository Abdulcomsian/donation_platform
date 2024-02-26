<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CampaignController, EventsController , MembershipController , DonationController};


Route::get('event-list/{id}' , [EventsController::class , 'getOrganizationEvents']);
Route::get('campaign-list/{id}' , [CampaignController::class , 'getOrganizationCampaigns']);
Route::get('membership-plans/{id}' , [MembershipController::class , 'getOrganizationMembershipPlans']);
Route::get('event-detail/{id}', [EventsController::class, 'getEventDetail']);
Route::get('donate-now/{campaign_id}', [DonationController::class, "getDonationForm"]);


