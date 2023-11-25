<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawl;

class PayoutController extends Controller
{
    public function payout(Request $request) {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'address' => 'required|string',
        ]);
        $user = auth()->user();
        // if(($user->wallet->balance ?? 0) < $data['amount']){
        //     return response()->json([
        //         'message' => 'Insufficient balance'
        //     ], 422);
        // }
        // if($user->paidReferrals()->count() < 7){
        //     return response()->json([
        //         'message' => 'You need at least 7 referrals to request payout'
        //     ], 422);
        // }
        $payout = new Withdrawl();
        $payout->user_id = $user->id;
        $payout->amount = $data['amount'];
        $payout->account = $data['address'];
        $payout->payment_method_id = 1;
        $payout->save();
        return response()->json([
            'message' => 'Payout request sent successfully'
        ]);
    }
}
