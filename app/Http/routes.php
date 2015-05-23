<?php

Route::get('/welcome', 'WelcomeController@index');

Route::get('/', 'HomeController@index');

Route::resource('usuarios', 'UsersController');
Route::resource('productos', 'ProductsController');
// modelos asociados a producto
Route::group(['prefix' => 'productos'], function(){
  // features
  Route::get('/{productos}/feature/create', 'FeaturesController@create');
  Route::post('/{productos}/feature', 'FeaturesController@store');
  Route::get('/feature/{features}/edit', 'FeaturesController@edit');
  Route::put('/feature/{features}', 'FeaturesController@update');
  Route::patch('/feature/{features}', 'FeaturesController@update');
  Route::delete('/feature/{features}', 'FeaturesController@destroy');

  // mechanical info
  Route::get('/{productos}/info-mecanica/create', 'MechanicalInfoController@create');
  Route::post('/{productos}/info-mecanica', 'MechanicalInfoController@store');
  Route::get('/info-mecanica/{mechanicals}/edit', 'MechanicalInfoController@edit');
  Route::put('/info-mecanica/{mechanicals}', 'MechanicalInfoController@update');
  Route::patch('/info-mecanica/{mechanicals}', 'MechanicalInfoController@update');
  Route::delete('/info-mecanica/{mechanicals}', 'MechanicalInfoController@destroy');

  // characteristics
  Route::get('/{productos}/caracteristicas/create', 'CharacteristicsController@create');
  Route::post('/{productos}/caracteristicas', 'CharacteristicsController@store');
  Route::get('/caracteristicas/{mechanicals}/edit', 'CharacteristicsController@edit');
  Route::put('/caracteristicas/{mechanicals}', 'CharacteristicsController@update');
  Route::patch('/caracteristicas/{mechanicals}', 'CharacteristicsController@update');
  Route::delete('/caracteristicas/{mechanicals}', 'CharacteristicsController@destroy');

  // nutritional
  Route::get('/{productos}/valores-nutricionales/create', 'NutritionalsController@create');
  Route::post('/{productos}/valores-nutricionales', 'NutritionalsController@store');
  Route::get('/valores-nutricionales/{mechanicals}/edit', 'NutritionalsController@edit');
  Route::put('/valores-nutricionales/{mechanicals}', 'NutritionalsController@update');
  Route::patch('/valores-nutricionales/{mechanicals}', 'NutritionalsController@update');
  Route::delete('/valores-nutricionales/{mechanicals}', 'NutritionalsController@destroy');
});
Route::resource('categorias', 'CategoriesController');
Route::resource('rubros', 'SubCategoriesController');
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
