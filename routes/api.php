<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function(){

    
    // users routes
    Route::group(['prefix' => 'user'], function ($router) {
        Route::get('profile', [App\Http\Controllers\Api\UserController::class, 'profile']);
        Route::post('update', [App\Http\Controllers\Api\UserController::class, 'updateProfile']);
        Route::get('referrals', [App\Http\Controllers\Api\UserController::class, 'referrals']);
        Route::get('referrer', [App\Http\Controllers\Api\UserController::class, 'referrer']);
        Route::get('deposits', [App\Http\Controllers\Api\UserController::class, 'deposits']);
        Route::get('withdrawls', [App\Http\Controllers\Api\UserController::class, 'withdrawls']);
        Route::get('transactions', [App\Http\Controllers\Api\UserController::class, 'transactions']);
    });

    // payment routes
    Route::group([
        'prefix' => 'payment'
    ], function ($router) {
        Route::get('currencies', [App\Http\Controllers\Api\DepositController::class, 'currencies']);
        Route::post('crypto', [App\Http\Controllers\Api\DepositController::class, 'crypto']);
    });

    // payout routes
    Route::group([
        'prefix' => 'payout'
    ], function ($router) {
        Route::post('request', [App\Http\Controllers\Api\PayoutController::class, 'payout']);
    });
});


Route::group([
    'prefix' => 'webhooks'
], function ($router) {
    Route::post('nowpayments', [App\Http\Controllers\Api\PaymentHooksController::class, 'handleNowPaymentsIPN']);
});