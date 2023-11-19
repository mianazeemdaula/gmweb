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
    Route::post('reset-password', [App\Http\Controllers\Api\AuthController::class, 'resetPassword']);
    Route::post('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::group(['middleware' => 'auth:sanctum'], function(){

    
    // users routes
    Route::group(['prefix' => 'user'], function ($router) {
        Route::get('profile', [App\Http\Controllers\Api\UserController::class, 'profile']);
    });
});

Route::group([
    'prefix' => 'payment'
], function ($router) {
    Route::get('currencies', [App\Http\Controllers\Api\DepositController::class, 'currencies']);
    Route::post('crypto', [App\Http\Controllers\Api\DepositController::class, 'crypto']);
});

Route::group([
    'prefix' => 'webhooks'
], function ($router) {
    Route::get('nowpayments', [App\Http\Controllers\Api\PaymentHooksController::class, 'handleNowPaymentsIPN']);
});