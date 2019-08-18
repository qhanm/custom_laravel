<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function singup(Request $request){

        $rules = [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                "message" => "Error",
                "data" =>  $validator->errors(),
            ], 442);
        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  bcrypt($request->password);

        $user->save();

        return response()->json([
            'message' => 'Successfully created user!',
        ], 201);

    }

    public function login(Request $request){

        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                "message" => "Error",
                "data" =>  $validator->errors(),
            ], 442);
        }

        // get request field email and password
        $creadential = request(['email', 'password']);

        if(!Auth::attempt($creadential)){
            return response()->json([
                'message' => "Unauthorized",
            ]);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        
        // $request->remember_me == true
        if($request->remember_me){
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();

        return response()->json([
            'message' => "Successfully logged",
        ]);
    }

    public function user(Request $request){
        return response()->json([
            $request->user(),
        ]);
    }
}
