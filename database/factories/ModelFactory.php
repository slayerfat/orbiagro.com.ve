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

$factory->define(Orbiagro\Models\User::class, function ($faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'profile_id'     => 1,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Orbiagro\Models\Profile::class, function ($faker) {
    return [
        'description' => $faker->text,
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->define(Orbiagro\Models\Billing::class, function ($faker) {
    return [
        'bank_id'      => 1,
        'card_type_id' => 1,
        'card_number'  => $faker->creditCardNumber(),
        'bank_account' => $faker->uuid,
        'expiration'   => $faker->creditCardExpirationDateString(),
        'comments'     => $faker->text(),
        'created_by'   => 1,
        'updated_by'   => 1,
    ];
});

$factory->define(Orbiagro\Models\Maker::class, function ($faker) {
    return [
        'name'       => $faker->company(),
        'domain'     => $faker->domainName(),
        'url'        => $faker->url(),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Characteristic::class, function ($faker) {
    return [
        'height'     => rand(1, 1000),
        'width'      => rand(1, 1000),
        'depth'      => rand(1, 1000),
        'units'      => rand(1, 10),
        'weight'     => rand(1, 10000),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\MechanicalInfo::class, function ($faker) {
    return [
        'motor'        => rand(1, 16),
        'motor_serial' => rand(100000, 999999),
        'model'        => rand(1, 1000),
        'cylinders'    => rand(1, 16),
        'horsepower'   => rand(1, 10000),
        'mileage'      => rand(1, 999999),
        'traction'     => rand(1, 1000),
        'lift'         => rand(1, 1000),
        'created_by'   => 1,
        'updated_by'   => 1,
    ];
});

$factory->define(Orbiagro\Models\Nutritional::class, function ($faker) {
    $date = Carbon\Carbon::now()->addDays(rand(1, 15))
        ->addMonths(rand(1, 11))
        ->addYears(rand(1, 10))
        ->toDateString();

    return [
        'due'        => $date,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Feature::class, function ($faker) {
    return [
        'title'       => $faker->sentence(5),
        'description' => $faker->text,
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->define(Orbiagro\Models\Person::class, function ($faker) {
    return [
        'gender_id'      => 1,
        'nationality_id' => 1,
        'first_name'     => $faker->firstName,
        'first_surname'  => $faker->lastName,
        'identity_card'  => rand(99999, 99999999),
        'phone'          => $faker->phoneNumber,
        'birth_date'     => $faker->date,
        'created_at'     => Carbon\Carbon::now(),
        'updated_at'     => Carbon\Carbon::now(),
        'created_by'     => 1,
        'updated_by'     => 1,
    ];
});

$factory->define(Orbiagro\Models\Direction::class, function ($faker) {
    return [
        'parish_id'  => 1,
        'details'    => $faker->streetAddress,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Product::class, function ($faker) {
    $maker  = Orbiagro\Models\Maker::random()->first();
    $subCat = Orbiagro\Models\SubCategory::random()->first();

    return [
        'maker_id'        => $maker->id,
        'sub_category_id' => $subCat->id,
        'title'           => $faker->sentence(5),
        'description'     => $faker->text(),
        'heroDetails'     => $faker->text(),
        'price'           => $faker->randomFloat(2, 100, 9999999999),
        'quantity'        => $faker->randomDigitNotNull(),
        'created_by'      => 1,
        'updated_by'      => 1,
    ];
});

$factory->define(Orbiagro\Models\MapDetail::class, function ($faker) {
    return [
        'latitude'   => 10.492315,
        'longitude'  => -66.932899,
        'zoom'       => rand(5, 12),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Promotion::class, function ($faker) {
    $number = rand(1, 100);
    $promoType = Orbiagro\Models\PromoType::where('description', 'primavera')->first();

    return [
        'title'         => $faker->sentence(5),
        'promo_type_id' => $promoType->id,
        'percentage'    => $number / 10,
        'static'        => $number,
        'begins'        => Carbon\Carbon::now()->subYears(4)->toDateString(),
        'ends'          => Carbon\Carbon::now()->addYears(1)->toDateString(),
        'created_by'    => 1,
        'updated_by'    => 1,
    ];
});

$factory->define(Orbiagro\Models\Provider::class, function ($faker) {
    return [
        'name'            => $faker->company,
        'url'             => $faker->url,
        'contact_name'    => $faker->name,
        'contact_title'   => $faker->title,
        'contact_email'   => $faker->safeEmail,
        'contact_phone_1' => $faker->phoneNumber,
        'contact_phone_2' => $faker->phoneNumber,
        'contact_phone_3' => $faker->phoneNumber,
        'contact_phone_4' => $faker->phoneNumber,
        'email'           => $faker->safeEmail,
        'phone_1'         => $faker->phoneNumber,
        'phone_2'         => $faker->phoneNumber,
        'phone_3'         => $faker->phoneNumber,
        'phone_4'         => $faker->phoneNumber,
        'trust'           => rand(1, 100),
        'created_by'      => 1,
        'updated_by'      => 1,
    ];
});

$factory->define(Orbiagro\Models\Visit::class, function () {
    return [
        'user_id'    => 1,
        'total'      => rand(1, 100),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Category::class, function ($faker) {
    return [
        'description'    => $faker->sentence(3),
        'info'    => $faker->sentence(3),
        'slug'    => str_slug($faker->sentence(3)),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\SubCategory::class, function ($faker) {
    return [
        'description'    => $faker->sentence(3),
        'info'    => $faker->sentence(3),
        'slug'    => str_slug($faker->sentence(3)),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});
