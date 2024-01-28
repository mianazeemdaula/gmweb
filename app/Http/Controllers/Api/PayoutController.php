<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawl;
use App\Models\User;

class PayoutController extends Controller
{
    public function payout(Request $request) {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'address' => 'required|string',
        ]);
        $user = auth()->user();
        if(($user->wallet->balance ?? 0) < $data['amount']){
            return response()->json([
                'message' => 'Insufficient balance'
            ], 422);
        }
        // if($user->paidReferrals()->count() < 7){
        //     return response()->json([
        //         'message' => 'You need at least 7 referrals to request payout'
        //     ], 422);
        // }
        // if($request->status == 'pending'){
        //     return response()->json([
        //         'message' => 'Transfer request may proceed',
        //         'status' => 'continue',
        //     ]);
        // }
        $payout = new Withdrawl();
        $payout->user_id = $user->id;
        $payout->amount = $data['amount'];
        $payout->account = $data['address'];
        $payout->payment_method_id = 1;
        $payout->coin = strtoupper($request->currency);
        $payout->save();
        // $user->updateWallet(-$data['amount'], 'Payout request');
        return response()->json([
            'message' => 'Payout request sent successfully'
        ]);
    }

    public function transfer(Request $request) {
        $request->validate([
            'amount' => 'required|numeric',
            'username' => 'nullable|exists:users,username',
            'to' => 'required|in:username,invest',
            'status' => 'required|in:pending,completed',
        ]);
        $user = auth()->user();
        if(($user->wallet->balance ?? 0) < $request->amount){
            return response()->json([
                'message' => 'Insufficient balance'
            ], 422);
        }
        if($request->status == 'pending'){
            return response()->json([
                'message' => 'Transfer request sent successfully',
                'status' => 'continue',
            ]);
        }
        if($request->to == 'username'){
            $to = \App\Models\User::where('username', $request->username)->first();
            if(!$to){
                return response()->json([
                    'message' => 'User not found'
                ], 422);
            }
            $to->updateWallet($request->amount, 'Transfer from '.$user->username);
            $user->updateWallet(-$request->amount, 'Transfer to '.$to->username);
            return response()->json([
                'message' => 'Transfer to username successfully'
            ]);
        }else if($request->to == 'invest'){
            $deposit = new \App\Models\Deposit();
            $deposit->user_id = $user->id;
            $deposit->payment_method_id = 3;
            $deposit->amount = $request->amount;
            $deposit->tx_id = 'transfer';
            $deposit->status = 'completed';
            $deposit->description = 'Deposit from wallet';
            $deposit->save();
            $user->updateWallet(-$request->amount, 'Transfer for investment');
            return response()->json([
                'message' => 'Transfer to investment successfully'
            ]);
        }
        return response()->json(['message' => 'Somthing went wrong'],422);
    }
}
