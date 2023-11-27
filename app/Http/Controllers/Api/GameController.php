<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function bet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        $user = $request->user();
        $amount = $request->amount;
        $user->updateWallet(-$amount, 'Bet for game');
        return response()->json([
            'message' => 'Bet placed successfully',
            'data' => [
                'amount' => $amount,
                'balance' => $user->wallet->balance,
            ],
        ]);
    }
    
    public function won(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        $user = $request->user();
        $user->updateWallet($amount, 'Win from game');
        return response()->json([
            'message' => 'You won the game',
            'data' => [
                'amount' => $amount,
                'balance' => $user->wallet->balance,
            ],
        ]);
    }
}
