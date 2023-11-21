<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PasswordReset;;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only(['email', 'password']);
        if(!$token = auth()->attempt($credentials)){
            return response()->json(['message' => 'The email or password not matched'], 422);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'image' => 'required|image',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|unique:users,phone',
            'referrer' => 'nullable|exists:users,tag',
        ]);
        $image_name = null;
        if($request->has('image')){
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('users'), $image_name);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'image' => $image_name ?? 'default.png',
            'password' => bcrypt($request->password),
            'tag' => Str::random(10),
            'phone' => $request->phone,
        ]);
        if($request->has('referrer')){
            $referrer = User::whereTag($request->referrer)->first();
            if($referrer){
                $user->referral = $referrer->id;
                $user->save();
            }
        }
        $token = $user->createToken('auth')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function resetPassword(Request $request){
        $credentials = $request->only(['email']);
        if(!$token = auth()->attempt($credentials)){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['token' => $token]);
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function sendResetPasswordPin(Request $request)
    {
        $code = rand(100000,999999);
        $user =  User::where('email', $request->email)->first();
        if(!$user){
            return  response()->json(['message' => 'Email not exists'], 204);
        }
        $data = PasswordReset::where('email', $request->email)->first();
        if($data){
            PasswordReset::where('email', $request->email)->delete();
        }
        PasswordReset::insert([
            'email' => $request->email,
            'token' => $code,
            'created_at' => now(),
        ]);
        Mail::to($request->email)->send(new VerifyApiEmail($code));
        return response()->json(['message' => 'Email sent successfully'], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:password_resets',
            'password' => 'required',
            'email' => 'required',
        ]);
        $data = PasswordReset::where('email', $request->email)->first();
        if($data){
            if ($data->created_at->addMinutes(15) < now()) {
                PasswordReset::where('email', $request->email)->delete();
                return response(['message' => trans('passwords.code_is_expire')], 422);
            }
            $user = User::where('email', $request->email)->first();
            $user->password = bcrypt($request->password);
            $user->save();
            PasswordReset::where('email', $user->email)->delete();
            return response()->json(['message'=> 'Password reset successfully'], 200);
        }
        return response()->json(['message'=> 'email verification not in process'], 409);
    }

}
