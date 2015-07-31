<?php

use Illuminate\Database\Seeder;

class BankTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de Bank! ***");

    $bank = factory(App\Bank::class, 'sinBanco')->create();

    $this->command->info("{$bank->description} creado.");

    $bank = factory(App\Bank::class, 3)->create();

    $this->command->info("{$bank} creados.");

    $this->command->info('Creacion de bancos completo.');
  }

}
