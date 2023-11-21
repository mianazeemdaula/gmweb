<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function payout(Request $request) {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'currency' => 'required|string',
            'address' => 'required|string',
        ]);
        return response()->json([
            'message' => 'Payout request sent successfully'
        ]);
    }
}
