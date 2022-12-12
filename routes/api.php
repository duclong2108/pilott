<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::namespace('Api')->group(function () {
  Route::post('/check-email-mobile', 'UserController@checkEmailMobile');
  Route::post('/login', 'UserController@login');
  Route::post('/register', 'UserController@register');
  Route::match(['get','post'],'/send-email', 'UserController@sendEmail');
  Route::post('/check-otp', 'UserController@checkOtp');
  Route::post('/reset-password', 'UserController@resetPassword');
  Route::get('/home', 'HomeController@home');
  Route::group(['middleware'=>'auth:api'], function(){
    Route::post('/bets', 'NumberPicker@Bets');
    Route::get('/logout', 'UserController@logout');
    Route::get('/history', 'NumberController@history');
    Route::post('/get-prize', 'NumberController@getPrize');

    Route::get('/sidebar', 'UserController@sidebar');
    Route::match(['get','post'], '/profile', 'UserController@profile');
    Route::get('/money', 'UserController@money');
    Route::get('/policy', 'HomeController@policy');
    Route::get('/app', 'HomeController@app');
    Route::get('/recharge', 'UserController@recharge');
  });
 
});