<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, HomeController, DonationController, CampaignController, DashboardController, EventsController, MailingController, MembershipController, SettingController, StripeController , IntegrationController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);

Route::group(['middleware' => ['preventBackHistory', 'auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout-user', [UserController::class, 'logoutUser'])->name('logout.user');
    
    Route::group(['prefix' => 'donations'] , function(){
        Route::get('/', [DonationController::class, 'donations'])->name('donations');
        Route::get('/donors', [DonationController::class, 'donors'])->name('donors');
        Route::post('/donation-list' , [DonationController::class , 'getDonationList'])->name('get.donations');
        Route::post('load-donation-stats' ,[DonationController::class , 'getDonationDashboardStats'])->name('load.donation.dashboard.stats');
    });

    // Route::get('/donors', [DonationController::class, 'donors'])->name('donors');
    // Route::get('/donations', [DonationController::class, 'donations'])->name('donations');
    Route::group(['prefix' => 'campaigns'], function () {
        Route::get('/', [CampaignController::class, 'campaign'])->name('campaigns');
        Route::get('/create-campaign', [CampaignController::class, 'getCampaignForm'])->name('campaign.create.form');
        Route::post('create-campaign', [CampaignController::class, 'createCampaign'])->name('create.campaign');
        Route::get('/edit-campaign/{id}', [CampaignController::class, 'editCampaignForm'])->name('campaign.edit.form');
        Route::get('/delete-campaign/{id}' , [CampaignController::class ,'deleteCampaign'])->name('delete.campaign');
        Route::post('/edit-campaign', [CampaignController::class, 'editCampaign'])->name('edit.campaign');
        Route::get('/campaign-created', [CampaignController::class, 'campaignCreated'])->name('campaign.created');
        Route::get('/campaign-updated', [CampaignController::class, 'campaignUpdated'])->name('campaign.updated');
    });

    Route::get('/connect' , [StripeController::class , 'connectStripe'])->name('connect.with.stripe');
    Route::get('/remove-connected-account' , [StripeController::class , 'removeConnectedAccount'])->name('remove.connected.stripe');
    Route::get('/stripe/connect' , [StripeController::class ,'stripeHostedOnboarding'])->name('stripe.hosted.onboarding');
    Route::get('/stripe/connect/callback', [StripeController::class, 'handleConnectCallback'])->name('stripe.connect.callback');
    Route::get('/remove-stripe-connected-account' , [StripeController::class , 'removeStripeConnectedAccount'])->name('remove.connected.stripe.account');

    Route::group(['prefix' => 'events'], function () {
        Route::get("/", [EventsController::class, 'getEventList'])->name('events');
        Route::get("/create-event", [EventsController::class, 'getEventForm'])->name('event.create.form');
        Route::get('edit-event/{id}' , [EventsController::class , 'editEventForm'])->name('edit.event');
        Route::post("create-event" , [EventsController::class , 'createEvent'])->name('create.event');
        Route::post("edit-event" , [EventsController::class , 'editEvent'])->name('edit.event');
        Route::get("delete-event" , [EventsController::class , 'deleteEvent'])->name('delete.event');
        Route::get('event-created' , [EventsController::class , 'eventCreated'])->name('event.created');
        Route::get('event-updated/{id?}', [EventsController::class, 'eventUpdated'])->name('event.updated');
        Route::post('purchase-ticket' , [EventsController::class , 'purchaseEventTicket'])->name('purchase.ticket');
    });

    Route::group(['prefix' => 'membership'], function () {
        Route::get("/", [MembershipController::class, 'membership'])->name('membership');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get("/", [SettingController::class, 'settings'])->name('settings');
        Route::post("change-profile-setting",[SettingController::class , 'changeProfileSettings'])->name('change.profile');
        Route::post("change-password" , [SettingController::class , 'changePassword'])->name('change.password');
        Route::post("update-orgainzation" , [SettingController::class , 'updateOrganization'])->name('update.organization');
        Route::post("get-user-list" , [UserController::class , 'getUserList'])->name('user.list');
        Route::post("add-new-user" , [UserController::class , 'addUser'])->name('add.user');
        Route::post("update-role" , [UserController::class , 'updateRole'])->name('update.role');
        Route::post("delete-user" , [UserController::class , 'deleteUser'])->name('delete.user');
        Route::get('get-mailchimp-lists' , [IntegrationController::class , 'getMailchimpLists']);
        Route::post('integrate-mailchimp-api' , [IntegrationController::class , 'integrateMailchimp'])->name('integrate.mailchimp');
    });

    Route::group(['prefix' => 'email'] , function(){
        Route::post('update-template' , [MailingController::class , 'updateUserMail'])->name('update.email.template');
    });

    Route::get("create-mail" , [MailingController::class , 'updateUserMail'])->name('update.mail');
    Route::view('/unauthorized' , 'unauthorized')->name('unauthorized');
});


Route::get('recent-events', [EventsController::class, 'getRecentEvents'])->name('publicEvents');
Route::get('event-detail/{id}', [EventsController::class, 'getEventDetail'])->name('event.detail');
Route::get('donate-now/{campaign_id}', [DonationController::class, "getDonationForm"])->name('get.donation.form');
Route::post('add-donation' , [DonationController::class , 'addDonation'])->name('add.donation');
Route::post('get-cities-list' , [HomeController::class , 'getCitiesList'])->name('get.country.cities');


// Route::any('{any}', function () {
//     return redirect('/dashboard');
// })->where('any', '.*');
