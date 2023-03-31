<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function register(Request $request){

    // $validator= Validator::make($request->all(),[
    //   'name' => 'required|string|min:4|max:200',
    //   'email' => 'required|string|email|max:200|unique',
    //   'password' => 'required|string|min:6|confirmed'
    // ]);

    $validator  = Validator::make($request->all(), [
        'name'  => 'required|string',
        'email'      => 'required|unique:users,email|string',
        'password'     => 'required'
    ]);


    if($validator->fails())
    {
        return response()->json($validator->errors(),400);
    }

    $user= User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'message' => 'User Successfully Registered',
        'user' => $user
    ]);


   }
}
