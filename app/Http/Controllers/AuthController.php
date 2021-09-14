<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
       try {
        if(Auth::attempt($request->only('email', 'password')))
        {
           $user= Auth::User();
           $token=$user->createToken('app')->accessToken;

           return response ([
               'message'=>"successfully login",
               'token'=>$token,
               'user'=>$user
           ]);
        }
       } catch(Exception $exception){
           return response([
               'message'=>$exception->getMessage()
           ],400);
       }

        return response([
            'message'=>"invalide email or password"
        ],401);
    }




    public function register(RegisterRequest $request)
    {
        
    try {
      
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        $token=$user->createToken('app')->accessToken;

        return response([
            'message'=>'succesfully registration',
            'token'=>$token,
               'user'=>$user
        ],400);
    } catch(Exception $exception){
      
        return response([
            'message'=>$exception->getMessage()
        ],401);
    }
    }
}
