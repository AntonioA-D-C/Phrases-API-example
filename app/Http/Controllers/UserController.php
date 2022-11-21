<?php

namespace App\Http\Controllers;

use Error;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        return User::all();
    }
    public function read(){
        $id = Auth::id();
        $users = User::find($id);
        return new UserResource($users);
    }
    public function editpicture(Request $request){
        $id = Auth::id();
        $users = User::find($id);
        if ($request->hasFile('profile_pic')){
            $file = $request->file('profile_pic');
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString()); 
            $name = $timestamp. '-' .$file->getClientOriginalName();
            $users->profile_pic = $name;
        $users->profile_pic=$request->profile_pic;
        $file->move(public_path().'/images/', $name);         
 
    }

    $users->save();
    return new UserResource($users);
    }

}
/*

if($request->profile_picture && $request->profile_pic->isValid()){
    $file_name= time().'.'.$request->profile_pic->extension();
    $request->profile_pic->move(public_path('images'), $file_name);
    $path= "public/images/$file_name";
    $users->profile_pic=$path;
}
 $users->update();
return response()->json(['status'=>'true', 'message'=>"Prfoile Updated!", 'data'=> $user]);
*/