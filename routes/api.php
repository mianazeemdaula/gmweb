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
    Route::post('forget-password', [App\Http\Controllers\Api\AuthController::class, 'sendResetPasswordPin']);
    Route::post('reset-password', [App\Http\Controllers\Api\AuthController::class, 'changePassword']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function(){    
    // users routes
    Route::group(['prefix' => 'user'], function ($router) {
        Route::post('send-otp', [App\Http\Controllers\Api\UserController::class, 'sendOTP']);
        Route::post('verify-otp', [App\Http\Controllers\Api\UserController::class, 'verifyOTP']);
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
        Route::get('status/{id}', [App\Http\Controllers\Api\DepositController::class, 'status']);
    });

    // payout routes
    Route::group([
        'prefix' => 'payout'
    ], function ($router) {
        Route::post('request', [App\Http\Controllers\Api\PayoutController::class, 'payout']);
        Route::post('transfer', [App\Http\Controllers\Api\PayoutController::class, 'transfer']);
    });

    // Game routes
    Route::group([
        'prefix' => 'game'
    ], function ($router) {
        Route::post('bet', [App\Http\Controllers\Api\GameController::class, 'bet']);
        Route::post('won', [App\Http\Controllers\Api\GameController::class, 'won']);
        Route::get('history', [App\Http\Controllers\Api\GameController::class, 'history']);
    });
});



Route::group([
    'prefix' => 'app'
], function ($router) {
    Route::get('data', [App\Http\Controllers\Api\AppController::class, 'data']);
    Route::get('levels', [App\Http\Controllers\Api\AppController::class, 'levels']);
    Route::get('payment-methods', [App\Http\Controllers\Api\AppController::class, 'paymentMethods']);
    Route::get('faq-categories', [App\Http\Controllers\Api\AppController::class, 'faqCategories']);
    Route::get('faqs', [App\Http\Controllers\Api\AppController::class, 'faqs']);
    Route::post('contact-us', [App\Http\Controllers\Api\AppController::class, 'contactUs']);
    Route::get('offers', [App\Http\Controllers\Api\AppController::class, 'offers']);
});

Route::group([
    'prefix' => 'webhooks'
], function ($router) {
    Route::post('nowpayments', [App\Http\Controllers\Api\PaymentHooksController::class, 'handleNowPaymentsIPN']);
});