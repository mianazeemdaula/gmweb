<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\NowPayment;
use Illuminate\Support\Str;

class DepositController extends Controller
{
    public function currencies()
    {
        try {
            $api = new NowPayment();
            $currencies = $api->currencies();
            return response()->json($currencies);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    public function crypto(Request $request)
    {
        try {
            $data = [
                "price_amount" => $request->price_amount ??  10.0,
                "price_currency"=> $request->price_currency ??  "usd",
                "pay_currency" => $request->pay_currency ?? "usdttrc20",
                "ipn_callback_url" => $request->callback ?? url('/api/webhooks/nowpayments'),
                "order_id" =>  $request->tag ?? Str::uuid(),
                "order_description" => "Deposit to GM",
                "is_fixed_rate"=> true,
                "is_fee_paid_by_user" => false
            ];
            $payment = (new NowPayment())->payment($data);
            // return response()->json($payment);
            return response()->json([
                'address' => $payment['pay_address'],
                'amount' => $payment['price_amount'],
                'amount_to_pay' => $payment['pay_amount'],
                'expire_at' => $payment['time_limit'],
                'payment_id' =>  $payment['payment_id'],
                'currency' => $payment['pay_currency'],
                'status' => $payment['payment_status'],
            ]);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage());
        }
    }

    
}
