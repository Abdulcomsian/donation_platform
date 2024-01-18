<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, HomeController, DonationController, CampaignController, DashboardController, EventsController, MembershipController, SettingController};

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
    Route::post('get-cities-list' , [HomeController::class , 'getCitiesList'])->name('get.country.cities');
    Route::get('/donors', [DonationController::class, 'donors'])->name('donors');
    Route::get('/donations', [DonationController::class, 'donations'])->name('donations');
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

    Route::group(['prefix' => 'events'], function () {
        Route::get("/", [EventsController::class, 'event'])->name('events');
        Route::get("/create-event", [EventsController::class, 'getEventForm'])->name('event.create.form');
    });

    Route::group(['prefix' => 'membership'], function () {
        Route::get("/", [MembershipController::class, 'membership'])->name('membership');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get("/", [SettingController::class, 'settings'])->name('settings');
    });
});


Route::get('events', [EventsController::class, 'getEvents'])->name('events');
Route::get('events/{id}', [EventsController::class, 'getEventDetail'])->name('event.detail');
Route::get('donate-now/{campaign_id}', [DonationController::class, "getDonationForm"])->name('get.donation.form');
Route::post('add-donation' , [DonationController::class , 'addDonation'])->name('add.donation');


Route::any('{any}', function () {
    return redirect('/dashboard');
})->where('any', '.*');
