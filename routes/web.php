<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ HomeController , DonationController , CampaignController };

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

Route::group(['middleware' => ['auth']] , function(){
    Route::get('/donors' , [DonationController::class , 'donors'])->name('donors');
    Route::get('/donations' , [DonationController::class , 'donations'])->name('donations');
    Route::get('/campaigns' , [CampaignController::class , 'campaign'])->name('campaigns');
});



Route::get('/home', [HomeController::class, 'index'])->name('home');
