<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Bank;
use App\User;

class BankTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de Bank! ***");

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    $faker = Faker::create('es_ES');

    $bank = Bank::create([
      'description' => 'Sin Banco Asociado',
      'created_by'  => $user->id,
      'updated_by'  => $user->id,
    ]);

    $this->command->info("{$bank->description} creado.");
    foreach(range(1, 10) as $index):
      $bank = Bank::create([
        'description' => 'Banco '.$faker->company(),
        'created_by'  => $user->id,
        'updated_by'  => $user->id,
      ]);
      $this->command->info("{$bank->description} creado.");
    endforeach;
    $this->command->info('Creacion de bancos completo.');
  }

}
