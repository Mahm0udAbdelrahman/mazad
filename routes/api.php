<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\InsuranceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register", [RegisterController::class ,'register']);
Route::post("/register/merchant", [RegisterController::class ,'registerMerchant']);
Route::post('/verify', [RegisterController::class, 'verify']);
Route::post('/otp', [RegisterController::class, 'otp']);
Route::post("/login", [LoginController::class ,'login']);





Route::post('/forget-password', [RegisterController::class, 'otp']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    // user
    Route::get('/profile', [LoginController::class, 'profile']);
    Route::post('/profile', [LoginController::class, 'updateProfile']);
    Route::post('/change-password', [LoginController::class, 'changePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);

    // car
    Route::get('/car', [CarController::class, 'index']);
    Route::post('/car', [CarController::class, 'store']);
    Route::get('/car/{id}', [CarController::class, 'show']);
    Route::post('/car/{id}', [CarController::class, 'update']);
    Route::delete('/car/{id}', [CarController::class, 'destroy']);


    // insurance
    Route::post('/insurance', [InsuranceController::class, 'store']);

});
Route::get('/callback', [InsuranceController::class, 'callback']);
