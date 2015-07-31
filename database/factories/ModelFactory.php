<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// implementado asi por la libreria en español
$faker = Faker\Factory::create('es_ES');

// usuario principal
$user = App\User::where('name', env('APP_USER'))->first();

$factory->define(App\User::class, function ($faker) {
  return [
    'name' => $faker->name,
    'email' => $faker->email,
    'password' => bcrypt(str_random(10)),
    'remember_token' => str_random(10),
  ];
});

// bank
$factory->define(App\Bank::class, function ($faker) use($user){
  return [
    'description' => 'Banco '.$faker->company(),
    'created_by'  => $user->id,
    'updated_by'  => $user->id,
  ];
});

$factory->defineAs(App\Bank::class, 'sinBanco', function ($faker) use ($factory) {
    $bank = $factory->raw(App\Bank::class);

    return array_merge($bank, ['description' => 'Sin Banco Asociado']);
});
