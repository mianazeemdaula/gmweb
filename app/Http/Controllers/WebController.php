<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\NowPayment;

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
            if(\Auth::user()->id == 1 || \Auth::user()->id == 2){
                return redirect()->route('dashboard');
            }else{
                \Auth::logout();
                return redirect()->route('/');
            }
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
        // $balance = (new NowPayment())->getBalance();
        return view('web.dashboard', [
            'deposit' => $deposit,
            'dailyCredit' => $dailyCredit,
            'days' => $deposit / ($dailyCredit == 0 ? 1 : $dailyCredit),
            'userCount' => $userCount,
            'userDepositCount' => $userDepositCount,
            // 'balance' => $balance,
        ]);
    }

    public function logout()
    {
        \Auth::logout();
        return redirect()->route('login');
    }

    public function nowPaymentPayout()
    {
        return view('admin.nowpayment.payout');
    }

    public function doNowPaymentPayout( Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'currency' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        $response = (new NowPayment())->payout($request);
        return $response;
    }

    public function verifyNowPaymentPayout(){
        return view('admin.nowpayment.payout_verify');
    }

    public function doverifyNowPaymentPayout(Request $request){
        $response = (new NowPayment())->verifyPayout($request);
        return $response;
    }
}
