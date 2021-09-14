<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetRequest;
use DB;
use Mail;
use App\mail\ForgotMail;
use App\User;


class ForgotController extends Controller
{
    public function forgotpassword(ForgotRequest $request)
    {
        $email=$request->email;
        if(User::where('email',$email)->doesntExist()){
            return response([
                'message'=>"Email Not Found"
            ],401);
        }

        $token=rand(10,100000);

       try {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token'=> $token
        ]);

        Mail::to($email)->send(New ForgotMail($token));
        return response([
            'message'=>'Reset Password Mail Send on Your Email'
        ],200);

       } catch (Exception $exception) {
           return response([
               'message'=>$exception->getMessage()
           ],400);
       }
    }



    public function resetpassword(ResetRequest $request)
    {
        $email=$request->email;
        $token=$request->token;
        $password=Hash::make($request->password);
        $emailcheck=DB::table('password_resets')->where('email',$email)->first();
        $pincheck=DB::table('password_resets')->where('token',$token)->first();

        if(!$emailcheck){
            return response([
            'message'=>"email Not found"
            ]);
        }
        
        if(!$pincheck){
            return response([
            'message'=>"Pincode Invalid"
            ]);
        }

        DB::table('users')->where('email',$email)->update(['password'=>$password]);
        DB::table('password_resets')->where('email',$email)->delete();

        return response ([
            'message'=>"password change Successfully"
        ],200);



    }
}
