<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
                            UserController, HomeController, DonationController, CampaignController, 
                            DashboardController, EventsController, MailingController, MembershipController, 
                            SettingController, StripeController , IntegrationController, PlanController};

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
    Route::post('/upload-organization-logo' , [DashboardController::class , 'uploadLogo'])->name('upload.logo');
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
        Route::get('/create-campaign', [CampaignController::class, 'getCampaignForm'])->name('campaign.create.form')->middleware(['authenticate.connected.account']);
        Route::post('create-campaign', [CampaignController::class, 'createCampaign'])->name('create.campaign');
        Route::get('/edit-campaign/{id}', [CampaignController::class, 'editCampaignForm'])->name('campaign.edit.form');
        Route::get('/delete-campaign/{id}' , [CampaignController::class ,'deleteCampaign'])->name('delete.campaign');
        Route::post('/edit-campaign', [CampaignController::class, 'editCampaign'])->name('edit.campaign');
        Route::get('/campaign-created/{campaignId}', [CampaignController::class, 'campaignCreated'])->name('campaign.created');
        Route::get('/campaign-updated/{campaignId}', [CampaignController::class, 'campaignUpdated'])->name('campaign.updated');
    });

    Route::get('/connect' , [StripeController::class , 'connectStripe'])->name('connect.with.stripe');
    Route::get('/remove-connected-account' , [StripeController::class , 'removeConnectedAccount'])->name('remove.connected.stripe');
    Route::get('/stripe/connect' , [StripeController::class ,'stripeHostedOnboarding'])->name('stripe.hosted.onboarding');
    Route::get('/stripe/connect/callback', [StripeController::class, 'handleConnectCallback'])->name('stripe.connect.callback');
    Route::get('/remove-stripe-connected-account' , [StripeController::class , 'removeStripeConnectedAccount'])->name('remove.connected.stripe.account');

    Route::group(['prefix' => 'events'], function () {
        Route::get("/", [EventsController::class, 'getEventList'])->name('events');
        Route::get("/create-event", [EventsController::class, 'getEventForm'])->name('event.create.form')->middleware(['authenticate.connected.account']);
        Route::get('edit-event/{id}' , [EventsController::class , 'editEventForm'])->name('edit.event');
        Route::post("create-event" , [EventsController::class , 'createEvent'])->name('create.event');
        Route::post("edit-event" , [EventsController::class , 'editEvent'])->name('edit.event');
        Route::get("delete-event" , [EventsController::class , 'deleteEvent'])->name('delete.event');
        Route::get('event-created/{eventId}' , [EventsController::class , 'eventCreated'])->name('event.created');
        Route::get('event-updated/{eventId}', [EventsController::class, 'eventUpdated'])->name('event.updated');
        Route::post('purchase-ticket' , [EventsController::class , 'purchaseEventTicket'])->name('purchase.ticket');
        Route::get('get-purchase-ticket-list/{eventId}' , [EventsController::class , 'purchaseTicketList'])->name('ticket.list');
        Route::post('get-purchase-ticket-list' , [EventsController::class , 'eventPurchaseTickets'])->name('event.purchased.ticket');
    });

    Route::group(['prefix' => 'membership'], function () {
        Route::get("/", [MembershipController::class, 'membership'])->name('membership');
        Route::post('delete-membership-plan' , [MembershipController::class , 'removeMembership'])->name('delete.membership');
        Route::post('create-membership-plan' , [MembershipController::class , 'createMembershipPlan'])->name('create.membership')->middleware(['authenticate.connected.account']);
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get("/", [SettingController::class, 'settings'])->name('settings');
        Route::post("change-profile-setting",[SettingController::class , 'changeProfileSettings'])->name('change.profile');
        Route::post("change-password" , [SettingController::class , 'changePassword'])->name('change.password');
        Route::post("update-orgainzation" , [SettingController::class , 'updateOrganization'])->name('update.organization');
        Route::post("get-organization-admin-list" , [UserController::class , 'getOrganizationAdminList'])->name('organization.admin.list');
        Route::post("add-organization-admin" , [UserController::class , 'addOrganizationAdmin'])->name('add.organization.admin');
        Route::post("update-role" , [UserController::class , 'updateRole'])->name('update.role');
        Route::post("delete-user" , [UserController::class , 'deleteUser'])->name('delete.user');
        Route::get('get-mailchimp-lists' , [IntegrationController::class , 'getMailchimpLists']);
        Route::post('integrate-mailchimp-api' , [IntegrationController::class , 'integrateMailchimp'])->name('integrate.mailchimp');
    });

    Route::group(['prefix' => 'plans'] , function(){
        Route::post('create-plan' , [PlanController::class , 'createPlan'])->name('create.plan');
        Route::post('plan-list' , [PlanController::class , 'planList'])->name('plan.list');
        Route::post('delete-plan' , [PlanController::class , 'deletePlan'])->name('delete.plan');
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
Route::get('invite-link/{id}' , [UserController::class , 'invitationPasswordReset'])->name('invitation.password.reset');
Route::post('set-invitation-password' , [UserController::class , 'setInvitationPassword'])->name('set.invitation.password');
Route::get('membership-list/{id}' , [MembershipController::class , 'getMembershipList'])->name('get.membership.list');
Route::post('subscribe-membership' , [MembershipController::class , 'subscribeMembership'])->name('subscribe.membership');



//public links for mailing-template
Route::get('donation-success' , [MailingController::class , 'donationSuccess']);
Route::get('subscription-success' , [MailingController::class , 'subscriptionSuccess']);
Route::get('subscription-failed' , [MailingController::class , 'subscriptionFailed']);
Route::get('donation-refund' , [MailingController::class , 'donationRefund']);
Route::get('donation-subscription-canceled' , [MailingController::class , 'donationSubscriptionCanceled']);
Route::get('new-membership' , [MailingController::class , 'newMembership']);
Route::get('membership-renewal' , [MailingController::class , 'membershipRenewalSuccess']);
Route::get('membership-canceled' , [MailingController::class , 'membershipCanceled']);
Route::get('membership-renewal-failed' , [MailingController::class , 'membershipRenewalFailed']);
Route::get('membership-refund' , [MailingController::class , 'membershipRefund']);
Route::get('event-registration' , [MailingController::class , 'eventRegistration']);
Route::get('event-canceled' , [MailingController::class , 'eventCanceled']);
Route::get('event-ticket-refund' , [MailingController::class , 'eventTicketRefund']);  
