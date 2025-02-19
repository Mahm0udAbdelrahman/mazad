<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/register/vendor", [RegisterController::class ,'registerVendor']);
Route::post("/register/merchant", [RegisterController::class ,'registerMerchant']);
Route::post('/verify', [RegisterController::class, 'verify']);
Route::post('/otp', [RegisterController::class, 'otp']);
Route::post("/login", [LoginController::class ,'login']);





// Route::post('/forget-password', [LoginController::class, 'otp']);
Route::post('/reset-password', [LoginController::class, 'resetPassword']);



Route::group(['middleware' => ['auth:sanctum']], function () {
    // user
    Route::get('/profile', [LoginController::class, 'profile']);
    Route::post('/profile', [LoginController::class, 'updateProfile']);
    Route::post('/change-pass', [LoginController::class, 'changePassword']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
