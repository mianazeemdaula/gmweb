<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
