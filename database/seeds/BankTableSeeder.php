<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Bank;

class BankTableSeeder extends Seeder {

  public function run()
  {
    $faker = Faker::create('es_ES');
    $bank = Bank::create([
      'description' => 'Sin Banco Asociado',
    ]);
    $this->command->info("{$bank->description} creado.");
    foreach(range(1, 10) as $index):
      $bank = Bank::create([
        'description' => 'Banco '.$faker->company(),
      ]);
      $this->command->info("{$bank->description} creado.");
    endforeach;
    $this->command->info('Creacion de bancos completo.');
  }

}
