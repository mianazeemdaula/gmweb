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
    $user = \App\Models\User::find(1);
    $invest =  $user->deposits->sum('amount');
    $amount =  ($invest * 0.30) / 100;
    $user->updateWallet($amount, 'ROI');
    return $user->wallet->balance ?? 0;
    // return $user->referrals()->count();
    // TJyMq2FJUxJBzt4HNubQzdWaS9NbzAzeVs
    return view('welcome');
});

