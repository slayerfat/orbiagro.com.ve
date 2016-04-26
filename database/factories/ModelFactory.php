<?php

/**
 * Nos interesa que la cedula de indentidad no se repita para
 * no generar algun conflico al generar datos.
 *
 * @return int
 */
function makeCI()
{
    $number = rand(999999, 99999999);
    $user   = \Orbiagro\Models\Person::where('identity_card', $number)->get();
    if ($user->isEmpty()) {
        return $number;
    }

    return makeCI();
}

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Orbiagro\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->email,
        'profile_id'     => 1,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Orbiagro\Models\UserConfirmation::class, function (Faker\Generator $faker) {
    return [
        'data'    => $faker->text,
        'user_id' => 1,
    ];
});

$factory->define(Orbiagro\Models\Profile::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->text,
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->define(Orbiagro\Models\Billing::class, function (Faker\Generator $faker) {
    return [
        'bank_id'      => 1,
        'card_type_id' => 1,
        'card_number'  => $faker->creditCardNumber,
        'bank_account' => $faker->uuid,
        'expiration'   => $faker->creditCardExpirationDateString,
        'comments'     => $faker->text,
        'created_by'   => 1,
        'updated_by'   => 1,
    ];
});

$factory->define(Orbiagro\Models\Maker::class, function (Faker\Generator $faker) {
    return [
        'name'       => $faker->company,
        'domain'     => $faker->domainName,
        'url'        => $faker->url,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Characteristic::class, function () {
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

$factory->define(Orbiagro\Models\MechanicalInfo::class, function () {
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

$factory->define(Orbiagro\Models\Nutritional::class, function () {
    return [
        'due'        => '1999-09-09',
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Feature::class, function (Faker\Generator $faker) {
    return [
        'title'       => $faker->sentence(5),
        'description' => $faker->text,
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->define(Orbiagro\Models\Person::class, function (Faker\Generator $faker) {
    return [
        'gender_id'      => 1,
        'nationality_id' => 1,
        'first_name'     => $faker->firstName,
        'first_surname'  => $faker->lastName,
        'identity_card'  => makeCI(),
        'phone'          => $faker->phoneNumber,
        'birth_date'     => $faker->date(),
        'created_at'     => Carbon\Carbon::now(),
        'updated_at'     => Carbon\Carbon::now(),
        'created_by'     => 1,
        'updated_by'     => 1,
    ];
});

$factory->define(Orbiagro\Models\Direction::class, function (Faker\Generator $faker) {
    return [
        'parish_id'  => 1,
        'details'    => $faker->streetAddress,
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'maker_id'         => 1,
        'sub_category_id'  => 1,
        'quantity_type_id' => 1,
        'title'            => $faker->sentence(5),
        'description'      => $faker->text,
        'heroDetails'      => $faker->text,
        'price'            => $faker->randomFloat(2, 100, 9999999999),
        'quantity'         => $faker->randomDigitNotNull,
        'created_by'       => 1,
        'updated_by'       => 1,
    ];
});

$factory->defineAs(Orbiagro\Models\Product::class, 'realRelations', function () use ($factory) {
    $maker  = Orbiagro\Models\Maker::random()->first();
    $subCat = Orbiagro\Models\SubCategory::random()->first();

    $user = $factory->raw(Orbiagro\Models\Product::class);

    return array_merge(
        $user,
        [
            'maker_id'        => $maker->id,
            'sub_category_id' => $subCat->id,
        ]
    );
});

$factory->define(Orbiagro\Models\MapDetail::class, function () {
    return [
        'latitude'   => 10.492315,
        'longitude'  => -66.932899,
        'zoom'       => rand(5, 12),
        'created_by' => 1,
        'updated_by' => 1,
    ];
});

$factory->define(Orbiagro\Models\Promotion::class, function (Faker\Generator $faker) {
    $number = rand(1, 100);

    return [
        'title'         => $faker->sentence(5),
        'promo_type_id' => 1,
        'percentage'    => $number / 10,
        'static'        => $number,
        'begins'        => Carbon\Carbon::now()->subYears(4)->toDateString(),
        'ends'          => Carbon\Carbon::now()->addYears(1)->toDateString(),
        'created_by'    => 1,
        'updated_by'    => 1,
    ];
});

$factory->define(Orbiagro\Models\PromoType::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->word,
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->defineAs(Orbiagro\Models\Promotion::class, 'realRelations', function (Faker\Generator $faker) {
    $number = rand(1, 100);
    /** @var \Orbiagro\Models\Promotion $promoType */
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

$factory->define(Orbiagro\Models\Provider::class, function (Faker\Generator $faker) {
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

$factory->define(Orbiagro\Models\QuantityType::class, function (Faker\Generator $faker) {
    return [
        'desc' => $faker->word,
    ];
});

$factory->define(Orbiagro\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence(3),
        'info'        => $faker->sentence(3),
        'slug'        => str_slug($faker->sentence(3)),
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});

$factory->define(Orbiagro\Models\SubCategory::class, function (Faker\Generator $faker) {
    return [
        'description' => $faker->sentence(3),
        'info'        => $faker->sentence(3),
        'slug'        => str_slug($faker->sentence(3)),
        'created_by'  => 1,
        'updated_by'  => 1,
    ];
});
