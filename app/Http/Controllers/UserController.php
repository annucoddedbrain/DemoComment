<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        'password'     => 'required|string|min:6|confirmed'
    ]);


    if($validator->fails())
    {
        return response()->json([
            "code" => Response::HTTP_UNAUTHORIZED,
            'status' => false,
            'message' =>  ("Register Fails"),
            "errors" => $validator->errors(),
        ],Response::HTTP_UNAUTHORIZED);
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


   protected function loginErrors(): array
   {
       return [
           "email.required" => ("Email cannot be empty!"),
           "email.email" => ("The email field must be a valid email address."),
           "password.required" => ("The Password is required")
       ];
   }


   public function login(Request $request)
   {
    $validator  = Validator::make($request->all(), [
        'email'      => 'required|string|email',
        'password'     => 'required|string|min:6'
    ],$this->loginErrors());


    if($validator->fails())
    {
        return response()->json([
            "code" => Response::HTTP_UNAUTHORIZED,
            'status' => false,
            'message' =>  ("Invalid format of email or password"),
            "errors" => $validator->errors(),
        ],Response::HTTP_UNAUTHORIZED);
    }

    // Tokenization point

    $credentials = $request->only('email', 'password');
    if (auth()->attempt($credentials, $request->filled('remember'))) {
        $user = User::where(['email' => $request->email])->first();
        $user->token = $user->createToken(env("APP_TOKEN", ''))->plainTextToken;
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => true,
            "data" => $user,
            "message" => ("User has been logged successfully.")
        ], Response::HTTP_OK);
    }

    return response()->json([
        "code" => Response::HTTP_UNAUTHORIZED,
        "status" => false,
        "data" => [
            "user" => [],
        ],
        "message" => ("Invalid email or password")
    ], Response::HTTP_UNAUTHORIZED);
}
//     $token = auth()->attempt($validator->validated());
//     if(!$token)
//     {
//         return response()->json([
//             'error'=> "Unauthorized"
//         ]);
//     }

//    }

//    protected function respondeWithToken($token)
//    {
//     return response()->json([
//         'access_token' => $token,
//         'token_type' => 'bearer',
//         'expires_in' => auth()->attempt()->getTTL() * 60000

//         // 'expire_in' => auth()->factory()->getTTL()*60
//     ]); 
//    }
}
