<?php

Route::get('/welcome', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::resource('usuarios', 'UsersController');
Route::resource('productos', 'ProductsController');
// features de producto
Route::group(['prefix' => 'producto/feature'], function(){
  Route::get('/create/{productos}', 'FeaturesController@create');
  Route::post('/', 'FeaturesController@store');
  Route::get('/{features}/edit', 'FeaturesController@edit');
  Route::put('/{features}', 'FeaturesController@update');
  Route::delete('/{features}', 'FeaturesController@destroy');
});
Route::resource('categorias', 'CategoriesController');
Route::resource('sub-categorias', 'SubCategoriesController');
Route::resource('fabricantes', 'MakersController');

Route::group(['middleware' => 'user.verified'], function(){
  // usuario por verificar
  Route::get('/por-verificar', 'HomeController@unverified');
  // para generar confirmaciones de usuario
  Route::get('/generar-confirmacion', 'ConfirmationsController@generateConfirm');
  Route::get('/confirmar/{string}', 'ConfirmationsController@confirm');
});

Route::get('home', function(){
  return redirect('/');
});

// para ajax de direcciones
Route::get('/estados', 'DirectionsController@states');
Route::get('/municipios/{id}', 'DirectionsController@towns');
Route::get('/municipio/{id}', 'DirectionsController@town');
Route::get('/parroquias/{id}', 'DirectionsController@parishes');
Route::get('/parroquia/{id}', 'DirectionsController@parish');

Route::controllers([
  'auth' => 'Auth\AuthController',
  'password' => 'Auth\PasswordController',
]);
