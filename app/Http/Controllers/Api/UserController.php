<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\OTP;
use WaAPI\WaAPI\WaAPI;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyApiEmail;
use Carbon\Carbon;
use App\Models\Mining;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Models\Withdrawl;


class UserController extends Controller
{
    public function profile() {
        $user = auth()->user();
        $data['user'] = $user;
        $data['level'] = $user->level->name ?? 'Level 0';
        $data['wallet'] = $user->wallet->balance ?? 0;
        $data['earning'] = $user->transactions()->where('is_bonus',true)->sum('credit');
        $data['last_day_earning'] = $user->transactions()->whereDate('created_at', Carbon::today())
        ->where('is_bonus', true)->sum('credit');
        $data['deposit'] = $user->deposits()->sum('amount');
        $data['withdrawl'] = $user->withdrawls()->whereIn('status', ['completed','confirmed'])->sum('amount');
        $data['mining'] = Mining::where('user_id', $user->id)->where('mining_end', '>', now())->first();
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
        if($request->has('start_mining')){
            // $this->doMining($request);
            $user->mining_started_at = now();
        }
        $user->save();
        return $this->profile();
    }

    public function doMining(Request $request)  {
        
        $user = $request->user();
        $isMining = Mining::where('user_id', $user->id)->first();
        if($isMining){
            return response()->json(['message'=> 'You are already mining'], 422);
        }
        $amount = ($user->level->return_percentage * $user->deposits()->sum('amount')) / 100;
        $referralEarnings = 0;
        // Level 1 Referrals
        foreach ($user->paidReferrals as $referral) {
            $referralEarnL1 = ($referral->level->return_percentage * $referral->deposits()->sum('amount')) / 100;
            $earnOnL1 = ($referralEarnL1 * 8) / 100;
            $referralEarnings += $earnOnL1;
            // Level 2 Referrals
            foreach ($referral->paidReferrals as $referralL2) {
                $referralEarnL2 = ($referralL2->level->return_percentage * $referralL2->deposits()->sum('amount')) / 100;
                $earnOnL2 = ($referralEarnL2 * 5) / 100;
                $referralEarnings += $earnOnL2;
                // Level 3 Referrals
                foreach ($referralL2->paidReferrals as $referralL3) {
                    $referralEarnL3 = ($referralL3->level->return_percentage * $referralL3->deposits()->sum('amount')) / 100;
                    $earnOnL3 = ($referralEarnL3 * 3) / 100;
                    $referralEarnings += $earnOnL3;
                }
            }
        }
        $mining = new Mining();
        $mining->user_id = $user->id;
        $mining->amount = $amount;
        $mining->ref_amount = $referralEarnings;
        $mining->mining_end = now()->addDays(1);
        $mining->save();
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
        $deposits = $user->deposits()
        ->latest()
        ->with(['payment_method' => function($q){
            $q->select('id', 'name', 'logo');
        }])->paginate();
        return response()->json($deposits);
    }

    public function withdrawls(){
        $user = auth()->user();
        $withdrawls = $user->withdrawls()->latest()->paginate();
        return response()->json($withdrawls);
    }

    public function transactions(){
        $user = auth()->user();
        $transactions = $user->transactions()->latest()->paginate();
        return response()->json($transactions);
    }

    public function refStatistics(){
        $user = auth()->user();
        $l1RefIds = $user->referrals->pluck('id');
        $l2RefIds = User::whereIn('referral', $l1RefIds)->pluck('id');
        $l3RefIds = User::whereIn('referral', $l2RefIds)->pluck('id');
        $refIds = array_merge($l1RefIds->toArray(), $l2RefIds->toArray(), $l3RefIds->toArray());
        $data['total_earning'] = Wallet::whereIn('user_id', $refIds)->where('is_bonus',true)->sum('credit');
        $data['today_earning'] = Wallet::whereIn('user_id', $refIds)->whereDate('created_at',now())->where('is_bonus',true)->sum('credit');
        $data['total_deposit'] = Deposit::whereIn('user_id', $refIds)->sum('amount');
        $data['today_deposit'] = Deposit::whereIn('user_id', $refIds)->whereDate('created_at',now())->sum('amount');
        $data['total_withdrawl'] = Withdrawl::whereIn('user_id', $refIds)->whereIn('status', ['completed','confirmed'])->sum('amount');
        $data['today_withdrawl'] = Withdrawl::whereIn('user_id', $refIds)->whereIn('status', ['completed','confirmed'])->whereDate('created_at',now())->sum('amount');
        $data['l1_ref_count'] = count($l1RefIds);
        $data['l2_ref_count'] = count($l2RefIds);
        $data['l3_ref_count'] = count($l3RefIds);
        return response()->json($data); 
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
