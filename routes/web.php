<?php

use Illuminate\Support\Facades\Route;
use Goutte\Client;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/

// Route::get('/', function () {
//   $client = new Client();
//   $crawler = $client->request('GET', 'https://xoso.me/');
//   $crawler->filter('span.v-gdb.bg-orange')->each(function ($node) {
//     echo $node->text() . "</br>";
//   });
// });



Route::prefix('admin')->namespace('Admin')->group(function () {
  Route::match(['get', 'post'], '/', 'AdminController@login');
  Route::group(['middleware' => 'admin'], function () {
    Route::match(['get', 'post'], '/account', 'AdminController@account');
    Route::get('/logout', 'AmdinController@logout');
    Route::get('/dashboard', 'AdminController@dashboard');
    Route::match(['get','post'],'/money', 'AdminController@money');
    Route::match(['get','post'],'/policy', 'AdminController@policy');
    Route::match(['get','post'],'/app', 'AdminController@app');

    Route::get('/games', 'GameController@index');
    Route::post('/create-game', 'GameController@create');
    Route::post('/edit-game/{id}', 'GameController@edit');
    Route::get('/delete-game/{id}', 'GameController@delete');

    Route::get('/users', 'UserController@index');
    Route::get('/recharge-user/{user_id}', 'UserController@recharge');

    //////////////////
    Route::get('/bet-users', 'UserController@betUser');
    Route::post('/count-date', 'UserController@countDate');
  });
});