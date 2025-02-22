<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\AuctionController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\InsuranceController;


// register
Route::post("/register", [RegisterController::class ,'register']);

// verify
Route::post('/verify', [RegisterController::class, 'verify']);
//login
Route::post("/login", [LoginController::class ,'login']);
//forget-password
Route::post('/forget-password', [PasswordController::class, 'forgetPassword']);
//reset-password
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);
// All Auction
Route::get('/auction', [AuctionController::class, 'index']);
//Details Auction
Route::get('/auction/{id}', [AuctionController::class, 'show']);

//filler Car

Route::get('car/filter',[CarController::class,'filter']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    // user
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::post('/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/change-password', [PasswordController::class, 'changePassword']);
    Route::post('/logout', [LogoutController::class, 'logout']);

    // car
    Route::get('/car', [CarController::class, 'index']);
    Route::post('/car', [CarController::class, 'store']);
    Route::get('/car/{id}', [CarController::class, 'show']);
    Route::post('/car/{id}', [CarController::class, 'update']);
    Route::delete('/car/{id}', [CarController::class, 'destroy']);
    Route::get('/car/pending', [CarController::class, 'getCarStatusPending']);
    Route::get('/car/approved', [CarController::class, 'getCarStatusApproved']);
    Route::get('/car/rejected', [CarController::class, 'getCarStatusRejected']);


    // insurance
    Route::post('/insurance', [InsuranceController::class, 'store']);

    //Auction
    Route::post('/auction/{id}', [AuctionController::class, 'commitAuction']);
    Route::get('/my-auctions', [AuctionController::class, 'getMyAuction']);
    Route::post('/auction/{id}/UpdateStatusAuction', [AuctionController::class, 'UpdateStatusAuction']);
});
Route::get('/callback', [InsuranceController::class, 'callback']);
