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
    \App\Jobs\CheckOfferWinJob::dispatch(2);
    \App\Jobs\CheckOfferWinJob::dispatch(5);
    \App\Jobs\CheckOfferWinJob::dispatch(14);
    return view('welcome');
});


Route::get('login', [\App\Http\Controllers\WebController::class, 'login']);
Route::post('login', [\App\Http\Controllers\WebController::class, 'doLogin'])->name('login');

Route::middleware(['auth'])->group(function(){
    Route::get('dashboard', [\App\Http\Controllers\WebController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [\App\Http\Controllers\WebController::class, 'logout'])->name('logout');

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function() {
        Route::resource('offers', \App\Http\Controllers\Admin\OfferController::class);
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
