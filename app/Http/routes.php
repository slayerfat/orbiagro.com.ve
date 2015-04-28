<?php

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
