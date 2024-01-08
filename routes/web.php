<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ UserController , HomeController , DonationController , CampaignController };

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth' , 'preventBackHistory']] , function(){
    Route::get('/logout-user' , [UserController::class , 'logoutUser'])->name('logout.user');
    Route::get('/donors' , [DonationController::class , 'donors'])->name('donors');
    Route::get('/donations' , [DonationController::class , 'donations'])->name('donations');
    Route::group(['prefix' => 'campaigns'] , function(){
        Route::get('/' , [CampaignController::class , 'campaign'])->name('campaigns');
        Route::get('/create-campaign' , [CampaignController::class , 'getCampaignForm'])->name('campaign.create.form');
    });
});

<<<<<<< HEAD
=======

// Route::get('/campaigns/create-compaign', function () {
//     return view('campaigns.create');
// })->name('campaigns.create');
>>>>>>> acafefd25657111275f36d5bbd6e69216e184ef0


Route::get('/home', [HomeController::class, 'index'])->name('home');
