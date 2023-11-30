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


Route::get('/test/{id}', function($id){
    $user = \App\Models\User::find($id);
    $percent =  ($user->level->return_percentage * $user->deposits()->sum('amount')) / 100;
    return [
        'level' => $user->level,
        'deposit' => $user->deposits()->sum('amount'),
        'percent' => $percent,];
});
