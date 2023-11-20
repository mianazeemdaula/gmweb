<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Deposit;

class PaymentHooksController extends Controller
{
    public function handleNowPaymentsIPN(Request $request)
    {
        $error_msg = "Unknown error";
        $auth_ok = false;
        $request_data = null;
        Log::error('NowPayments IPN request received');
        $payment_id = $request->input('payment_id');
        if($payment_id){
            $data = (new NowPayment())->getPayment($payment_id);
            if($data && $data['payment_status'] == 'finished'){
                $user = User::where('tag', $data['order_id'])->first();
                if($user){
                    $deposit = new Deposit();
                    $deposit->user_id = $user->id;
                    $deposit->payment_method_id = 1;
                    $deposit->amount = $data['pay_amount'];
                    $deposit->transaction_id = $payment_id;
                    $deposit->save();
                }
            }
        }
        if ($request->header('HTTP_X_NOWPAYMENTS_SIG')) {
            $received_hmac = $request->header('HTTP_X_NOWPAYMENTS_SIG');
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
            return response()->json($request->all());
        } else {

            Log::error($error_msg);
            return response()->json(['error' => $error_msg], 400);
        }
    }
}
