<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





//login 
Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');


//forgot password
Route::post('/forgotpassword','ForgotController@forgotpassword');

Route::post('/resetpassword','ForgotController@resetpassword');


//current user_error
Route::get('/user','UserController@user')->middleware('auth:api');



