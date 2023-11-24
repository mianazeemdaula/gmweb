<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\OTP;
use WaAPI\WaAPI\WaAPI;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyApiEmail;

class UserController extends Controller
{
    public function profile() {
        $user = auth()->user();
        $data['user'] = $user;
        $data['wallet'] = $user->wallet->balance ?? 0;
        $data['deposit'] = $user->deposits()->sum('amount');
        $data['withdrawl'] = $user->withdrawl->balance ?? 0;
        return response()->json($data);
    }

    public function updateProfile(Request $request){
        $user = auth()->user();
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('image')){
            $file = $request->image;
            $fileName = $user->id."_".time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('users'),$fileName);
            $user->image = $fileName;
        }
        $user->save();
        return $this->profile();
    }

    public function referrals(){
        $user = auth()->user();
        $referrals = $user->referrals()->paginate();
        return response()->json($referrals);
    }

    public function referrer(){
        $user = auth()->user();
        $referrer = $user->referrer;
        return response()->json($referrer);
    }

    public function deposits(){
        $user = auth()->user();
        $deposits = $user->deposits()->paginate();
        return response()->json($deposits);
    }

    public function withdrawls(){
        $user = auth()->user();
        $withdrawls = $user->withdrawls()->paginate();
        return response()->json($withdrawls);
    }

    public function transactions(){
        $user = auth()->user();
        $transactions = $user->transactions()->paginate();
        return response()->json($transactions);
    }

    
    public function sendOTP(Request $request){
        $request->validate([
            'action' => 'required|string',
        ]);
        $user = $request->user();
        $action = $request->action;
        if($user){
            $code = rand(100000,999999);
            if($action == 'phone'){
                $data = OTP::where('account', $user->phone)->first();
                if($data){
                    OTP::where('account', $user->phone)->delete();
                }
                $otp = new OTP();
                $otp->user_id = $user->id;
                $otp->account = $user->phone;
                $otp->token = $code;
                $otp->save();
                $wa = new WaAPI();
                $wa->sendMessage($user->phone.'@c.us', 'Your OTP is '.$code);
                return response()->json(['message'=> 'OTP sent successfully'], 200);
            }
            else if($action == 'email'){
                $data = OTP::where('account', $user->email)->first();
                if($data){
                    OTP::where('account', $user->email)->delete();
                }
                $otp = new OTP();
                $otp->user_id = $user->id;
                $otp->account = $user->email;
                $otp->token = $code;
                $otp->save();
                Mail::to($user->email)->send(new VerifyApiEmail($code));
                return response()->json(['message'=> 'OTP sent successfully'], 200);
            }
            return response()->json(['message'=> 'OTP sent successfully'], 200);
        }
        return response()->json(['message'=> 'Email verification not in process'], 409);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:o_t_p_s',
            'action' => 'required|string',
        ]);
        $user = $request->user();
        $otp = $request->token;
        $action = $request->action;
        if($user){
            if($action == 'phone'){
                $data = OTP::where('account', $user->phone)->first();
                if ($data->created_at->addMinutes(1) < now()) {
                    OTP::where('account', $request->phone)->delete();
                    return response(['message' => 'Phone OTP is expired'], 422);
                }
                $user->phone_verified_at = now();
                $user->save();
                OTP::where('account', $user->phone)->delete();
                return response()->json(['message'=> 'Phone verified successfully'], 200);
            }
            else if($action == 'email'){
                $data = OTP::where('account', $user->email)->first();
                if ($data->created_at->addMinutes(10) < now()) {
                    OTP::where('account', $request->email)->delete();
                    return response(['message' => 'Email OTP is expired'], 422);
                }
                $user->email_verified_at = now();
                $user->save();
                OTP::where('account', $user->email)->delete();
                return response()->json(['message'=> 'Email verified successfully'], 200);
            }
            return response()->json(['message'=> 'Email verified successfully'], 200);
        }
        return response()->json(['message'=> 'Email verification not in process'], 409);
    }
}
