<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile() {
        $data['user'] = auth()->user();
        $data['wallet'] = auth()->user()->wallet->balance ?? 0;
        $data['deposit'] = auth()->user()->deposit->balance ?? 0;
        $data['withdrawl'] = auth()->user()->withdrawl->balance ?? 0;
        return response()->json($data);
    }

    public function updateProfile(Request $request){
        $user = auth()->user();
        $user->name = $request->name;
        if($request->has('image')){
            $user->image = $request->image->store('users');
        }
        $user->save();
        return $this->profile();
    }
}
