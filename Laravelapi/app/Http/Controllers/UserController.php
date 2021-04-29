<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; 

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTManager as JWT;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserController extends Controller
{
    public function register(Request $request){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            if($validator->fails()){
                 $validation_error = $validator->errors()->all();
                return response()->json(["code" => 422, "message" =>  $validation_error[0] ]);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            //$token = JWTAuth::fromUser($user);

            return response()->json(["code" => 201, "message" =>  "Reguster Sucessfully", 
                "data" => $user]);

    }

    public function login(Request $request){

        $credentials = $request->all();
        $validator = Validator::make($credentials, [
            'email' => 'required|string|email|max:255   ',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            $validation_error = $validator->errors()->all();
            return response()->json(["code" => 422, "message" =>  $validation_error[0] ]);
        }


        try {
            if(! $token = JWTAuth::attempt($credentials)){
                    return response()->json(['code'=> 400 ,'message'=>'invalid Credentials']);
            }
        }catch (JWTException $e){
            return response()->json(['code'=> 500 , 'message'=>'could_not_create_token']);
        }

        $user = Auth::user();
        return response()->json(["code" => 201, "message" =>  "Login Sucessfully", 
                "user" => $user, "token" => $token]);

    }

    public function getAuthenticatedUser(){
        try{
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return response()->json(['code' => 400,'message' => 'user_not_found']);
            }
        }catch (TokenExpiredException $e){
            return response()->json(['code' => 401,'message' =>'token_expired']);
        }catch (TokenInvalidException $e){
            return response()->json(['code' => 402,'message' => 'token_invalid']);
        }catch (JWTException $e){
            return response()->json(['code' => 403,'message' => 'token_absent']);
        }

        return response()->json(["code" => 201, "message" =>  "Profile", "data" => $user]);
    }
}
