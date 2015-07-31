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

// perfil del usuario
$profileId = App\Profile::where('description', 'Usuario')->firstOrFail()->id;

$factory->define(App\User::class, function ($faker) use($profileId){
  return [
    'name'           => $faker->name,
    'email'          => $faker->email,
    'profile_id'     => $profileId,
    'password'       => bcrypt(str_random(10)),
    'remember_token' => str_random(10),
  ];
});

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

$factory->define(App\Billing::class, function ($faker) use($user){
  return [
    'user_id'      => App\User::all()->random()->id,
    'bank_id'      => App\Bank::all()->random()->id,
    'card_type_id' => App\CardType::all()->random()->id,
    'card_number'  => $faker->creditCardNumber(),
    'bank_account' => $faker->bankAccountNumber(),
    'expiration'   => $faker->creditCardExpirationDateString(),
    'comments'     => $faker->text(),
    'created_by'   => $user->id,
    'updated_by'   => $user->id,
  ];
});

$factory->define(App\Maker::class, function ($faker) use($user){
  return [
    'name'       => $faker->company(),
    'domain'     => $faker->domainName(),
    'url'        => $faker->url(),
    'created_by' => $user->id,
    'updated_by' => $user->id,
  ];
});

$factory->define(App\Characteristic::class, function ($faker) use($user){
  return [
    'height'     => rand(1, 1000),
    'width'      => rand(1, 1000),
    'depth'      => rand(1, 1000),
    'units'      => rand(1, 10),
    'weight'     => rand(1, 10000),
    'created_by' => $user->id,
    'updated_by' => $user->id,
  ];
});

$factory->define(App\MechanicalInfo::class, function ($faker) use($user){
  return [
    'motor'        => rand(1, 16),
    'motor_serial' => rand(100000, 999999),
    'model'        => rand(1, 1000),
    'cylinders'    => rand(1, 16),
    'horsepower'   => rand(1, 10000),
    'mileage'      => rand(1, 999999),
    'traction'     => rand(1, 1000),
    'lift'         => rand(1, 1000),
    'created_by'   => $user->id,
    'updated_by'   => $user->id,
  ];
});

$factory->define(App\Nutritional::class, function ($faker) use($user){
  $date = Carbon::now()->addDays(rand(1, 15))
                        ->addMonths(rand(1, 11))
                        ->addYears(rand(1, 10))
                        ->toDateString();
  return [
    'due'        => $date,
    'created_by' => $user->id,
    'updated_by' => $user->id,
  ];
});

$factory->define(App\Feature::class, function ($faker) use($user){
  return [
    'title'       => $faker->words,
    'description' => $faker->text,
    'created_by'  => $user->id,
    'updated_by'  => $user->id,
  ];
});

$factory->define(App\Person::class, function ($faker) use($user){
  return [
    'gender_id'      => 1,
    'nationality_id' => 1,
    'first_name'     => $faker->firstName,
    'first_surname'  => $faker->firstName,
    'identity_card'  => rand(99999, 99999999),
    'phone'          => $faker->phoneNumber,
    'birth_date'     => $faker->date,
    'created_at'     => Carbon\Carbon::now(),
    'updated_at'     => Carbon\Carbon::now(),
    'created_by'     => $user->id,
    'updated_by'     => $user->id,
  ];
});

$factory->define(App\Direction::class, function ($faker) use($user){
  return [
    'parish_id'      => 1,
    'details'        => $faker->sentence,
    'created_by'     => $user->id,
    'updated_by'     => $user->id,
  ];
});

$factory->define(App\Product::class, function ($faker) use($user){
  $maker  = App\Maker::random()->first();
  $subCat = App\SubCategory::random()->first();
  return [
    'maker_id'        => $maker->id,
    'sub_category_id' => $subCat->id,
    'title'           => $faker->words,
    'description'     => $faker->text(),
    'price'           => $faker->randomFloat(2, 100, 9999999999),
    'quantity'        => $faker->randomDigitNotNull(),
    'created_by'      => $user->id,
    'updated_by'      => $user->id,
  ];
});
