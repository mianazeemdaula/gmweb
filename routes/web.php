<?php

use Illuminate\Support\Facades\Route;

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
});

Route::get('/test/{id}', function($id){
    $user = \App\Models\User::find($id);
    $users = \App\Models\User::whereHas('deposit', function ($q) {
        $q->where('status', 'completed');
    })->get();
    $dailyCredit = \App\Models\Wallet::where('is_bonus', true)->sum('credit');
    $deposit = \App\Models\Deposit::where('status', 'completed')->sum('amount');
    return ['credit' => $dailyCredit, 'deposit' => $deposit, 'days' => $deposit / $dailyCredit];
    return $users->count();
});
