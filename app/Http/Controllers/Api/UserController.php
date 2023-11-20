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
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('image')){
            $file = $request->image;
            $fileName = $user->id."_".time().'.'.$file->getClientOriginalExtension();
            $user->image = $file->move(public_path('images'),$fileName);
        }
        $user->save();
        return $this->profile();
    }
}
