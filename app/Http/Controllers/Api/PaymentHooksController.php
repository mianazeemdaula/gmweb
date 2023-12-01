<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helper\NowPayment;
use App\Models\User;
use App\Models\Deposit;
use App\Events\DepositEvent;
use App\Models\Level;

class PaymentHooksController extends Controller
{
    public function handleNowPaymentsIPN(Request $request)
    {
        $error_msg = "Unknown error";
        $auth_ok = false;
        $request_data = null;
        if ($request->header('x-nowpayments-sig')) {
            $received_hmac = $request->header('x-nowpayments-sig');
            $request_json = $request->getContent();
            $request_data = json_decode($request_json, true);
            ksort($request_data); 
            $sorted_request_json = json_encode($request_data, JSON_UNESCAPED_SLASHES);
            if ($request_json !== false && !empty($request_json)) {
                $hmac = hash_hmac("sha512", $sorted_request_json, trim(env('NOWPAYMENTS_IPN_KEY')));
                if ($hmac == $received_hmac) {
                    $auth_ok = true;
                } else {
                    $error_msg = 'HMAC signature does not match';
                }
            } else {
                $error_msg = 'Error reading POST data';
            }
        } else {
            $error_msg = 'No HMAC signature sent.';
        }

        if ($auth_ok) {
            $payment_id = $request->input('payment_id');
            if($payment_id){
                $data = (new NowPayment())->getPayment($payment_id);
                if($data && $data['payment_status'] == 'finished'){
                    $user = User::where('tag', $data['order_id'])->first();
                    if($user){
                        $deposit = new Deposit();
                        $deposit->user_id = $user->id;
                        $deposit->payment_method_id = strtolower($data['outcome_currency']) == 'usdttrc20' ? 1 : 2;
                        $deposit->amount = $data['pay_amount'];
                        $deposit->tx_id = $payment_id;
                        $deposit->status = 'completed';
                        $deposit->description = 'Deposit from Crypto';
                        $deposit->save();
                        // DepositEvent::dispatch($deposit->toArray());
                        $amount = $user->deposits()->sum('amount');
                        $level = Level::where('min_price', '<=', $amount)
                        ->where('max_price', '>=', $amount)->first();
                        if($level){
                            $user->level_id = $level->id;
                            $user->save();
                        }
                        \App\Jobs\CheckOfferWinJob::dispatch($user->id);
                    }
                }
            }
        } else {
            Log::error($error_msg);
            return response()->json(['error' => $error_msg], 400);
        }
    }
}
