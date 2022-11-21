<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   public function register(Request $request)
   {
    $validator= Validator::make($request->all(),[
        'name' => 'required|string|max:255',
        'email'=> 'required|string|email|max:255|unique:users',
        'password'=>'required|string|min:8'
    ]);
    if($validator->fails()){
        return response()->json($validator->errors());
    }
    $users = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=> Hash::make($request->password)
    ]);
    $token = $users->createToken('auth_token')->plainTextToken;

    return response()->json(['data'=>$users, 'access_token'=>$token, 'token_type'=>'Bearer']);
   }

   public function login(Request $request){
    if(!Auth::attempt($request->only('email', 'password'))){
        return response()->json(['message=>Unauthorized'], 400);
    };
    $users= User::where('email', $request['email'])->firstOrFail();

    $token=$users->createToken('auth_token')->plainTextToken;

    return response()->json(['message'=> "Welcome ".$users->name,
    'accessToken'=>$token,
    'token_type'=>'Bearer',
    'user' =>$users,
]);
   }
   public function logout(){
    auth()->user()->tokens()->delete();
    return[
        'message' =>"Logged out, token deleted"
    ];
   }
}
