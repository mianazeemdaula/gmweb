<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    public function login()
    {
        return view('web.auth.login');
    }

    public function doLogin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (\Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return redirect()->back()->withErrors(['password' => 'Invalid Credentials']);
    }

    public function dashboard()
    {
        $deposit = \App\Models\Deposit::where('status', 'completed')->sum('amount');
        $dailyCredit = \App\Models\Wallet::where('is_bonus', true)->sum('credit');
        $userCount = \App\Models\User::count();
        $userDepositCount = \App\Models\User::whereHas('deposit', function ($q) {
            $q->where('status', 'completed');
        })->count();
        return view('web.dashboard', [
            'deposit' => $deposit,
            'dailyCredit' => $dailyCredit,
            'days' => $deposit / ($dailyCredit == 0 ? 1 : $dailyCredit),
            'userCount' => $userCount,
            'userDepositCount' => $userDepositCount,
        ]);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->route('login');
    }
}
