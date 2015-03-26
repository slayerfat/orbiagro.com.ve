<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/welcome', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::resource('usuarios', 'UsersController');
Route::resource('productos', 'ProductsController');

Route::get('home', function(){
  return redirect('/');
});

Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);
