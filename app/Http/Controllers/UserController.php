<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function register(Request $request)
   {
        $validator  = Validator::make($request->all(),[
            'name'  => 'required|string',
            'email'      => 'required|unique:users,email|string',
            'password'     => 'required|string|min:6|confirmed'
        ]);


        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }

        $user= User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->token;

        $user->token = $user->createToken(env("APP_TOKEN", ''))->plainTextToken;
      
        
        return response()->json([
            'message' => 'User Successfully Registered',
            'user' => $user
        ]);

        $user->save($token);
        
    }

    protected function loginErrors(): array
    {
        return [
            "email.required" =>("Email cannot be empty!"),
            "email.email" => ("The email field must be a valid email address."),
            "password.required" => ("The Password is required")
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request $request
     * 
     * @return Illuminate\Http\JsonResponse
     */

    public function login(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ], $this->loginErrors());

        if ($validator->fails()) {
            return response()->json([
                "code" => Response::HTTP_UNAUTHORIZED,
                'status' => false,
                'message' => ("Invalid format of email or password"),
                "errors" => $validator->errors(),
            ], Response::HTTP_UNAUTHORIZED);
        }
        
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


}