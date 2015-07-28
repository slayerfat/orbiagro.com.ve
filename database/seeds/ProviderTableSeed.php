<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;

class ProviderTableSeed extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Provider! ***");

    $faker = Faker::create('es_ES');
    $user  = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach(range(1, 2) as $index) :
      $this->command->info("Provider {$index}");
      $name = $faker->company();
      $this->command->info("Provider name: {$name}");
      $this->command->info("Provider slug: ".str_slug($name));
      App\Provider::create([
        'name'          => $name,
        'slug'          => str_slug($name),
        'url'           => $faker->url(),
        'contact_name'  => $faker->name(),
        'contact_title' => $faker->title(),
        'email'         => $faker->safeEmail(),
        'phone_1'       => $faker->phoneNumber(),
        'phone_2'       => $faker->phoneNumber(),
        'phone_3'       => $faker->phoneNumber(),
        'phone_4'       => $faker->phoneNumber(),
        'trust'         => rand(1, 100),
        'created_by'    => $user->id,
        'updated_by'    => $user->id,
      ]);
    endforeach;

    $this->command->info('providers completados.');
  }

}
