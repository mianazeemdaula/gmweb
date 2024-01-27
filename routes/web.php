<?php

use Illuminate\Support\Facades\Route;
use WaAPI\WaAPI\WaAPI;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', [\App\Http\Controllers\WebController::class, 'login']);
Route::post('login', [\App\Http\Controllers\WebController::class, 'doLogin'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::get('dashboard', [\App\Http\Controllers\WebController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [\App\Http\Controllers\WebController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('withdrawls', \App\Http\Controllers\Admin\WithdrawlController::class);
        Route::resource('levels', \App\Http\Controllers\Admin\LevelController::class);
        Route::resource('offers', \App\Http\Controllers\Admin\OfferController::class);
        Route::resource('deposits', \App\Http\Controllers\Admin\DepositController::class);

        // nowpayment payout
        Route::get('nowpayment/payout', [\App\Http\Controllers\WebController::class, 'nowPaymentPayout']);
        Route::post('nowpayment/payout', [\App\Http\Controllers\WebController::class, 'doNowPaymentPayout']);
        Route::get('nowpayment/payoutverify', [\App\Http\Controllers\WebController::class, 'verifyNowPaymentPayout']);
        Route::post('nowpayment/payoutverify', [\App\Http\Controllers\WebController::class, 'doverifyNowPaymentPayout']);
    });
});

Route::get('/test/{id}', function($id){
    $wa = new WaAPI();
   return $wa->sendMessage('923004103160@c.us', 'Your OTP is ');
    
    $waapi->sendTextMessage('923004103160', 'Hello World');
    $user = \App\Models\User::find($id);
    $users = \App\Models\User::whereHas('deposit', function ($q) {
        $q->where('status', 'completed');
    })->get();
    $dailyCredit = \App\Models\Wallet::where('is_bonus', true)->sum('credit');
    $deposit = \App\Models\Deposit::where('status', 'completed')->sum('amount');
    return ['credit' => $dailyCredit, 'deposit' => $deposit, 'days' => $deposit / $dailyCredit];
    return $users->count();
});


Route::get('/asdjflasjdflasdj/{id}', function($id){
    \App\Jobs\CheckOfferWinJob::dispatch($id);
    return 'done';
});