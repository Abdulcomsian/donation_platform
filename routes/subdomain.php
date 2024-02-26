<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CampaignController, EventsController , MembershipController};


Route::get('/campaigns/{userId}' , [CampaignController::class , 'getOrganizationCampaigns'])->name('organization.campaigns');
Route::get('/events/{userId}' , [EventsController::class , 'getOrganizationEvents'])->name('organization.events');
Route::get('/memberships/{userId}' , [MembershipController::class , 'getOrganizationMembershipPlans'])->name('organization.membership');


