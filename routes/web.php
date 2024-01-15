<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, HomeController, DonationController, CampaignController, DashboardController, EventsController, MembershipController};

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
    Route::get('/donors', [DonationController::class, 'donors'])->name('donors');
    Route::get('/donations', [DonationController::class, 'donations'])->name('donations');
    Route::group(['prefix' => 'campaigns'], function () {
        Route::get('/', [CampaignController::class, 'campaign'])->name('campaigns');
        Route::get('/create-campaign', [CampaignController::class, 'getCampaignForm'])->name('campaign.create.form');
        Route::post('create-campaign', [CampaignController::class, 'createCampaign'])->name('create.campaign');
        Route::get('/edit-campaign/{id}', [CampaignController::class, 'editCampaignForm'])->name('campaign.edit.form');
        Route::post('/edit-campaign', [CampaignController::class, 'editCampaign'])->name('edit.campaign');
        Route::get('/campaign-created', [CampaignController::class, 'campaignCreated'])->name('campaign.created');
    });

    Route::group(['prefix' => 'events'], function () {
        Route::get("/", [EventsController::class, 'event'])->name('events');
        Route::get("/create-event", [EventsController::class, 'getEventForm'])->name('event.create.form');
    });

    Route::group(['prefix' => 'membership'], function () {
        Route::get("/", [MembershipController::class, 'membership'])->name('membership');
    });

    Route::any('{any}', function () {
        return redirect('/dashboard');
    })->where('any', '.*');
});

Route::group(['prefix' => 'public'], function () {
    Route::get('/events', [EventsController::class, 'getPublicEvents'])->name('publicEvents');
    Route::get('/events/{id}', [EventsController::class, 'getEventDetail'])->name('eventDetail');
    Route::get('/donate-now', [DonationController::class, "donateNow"])->name('donateNow');
});
