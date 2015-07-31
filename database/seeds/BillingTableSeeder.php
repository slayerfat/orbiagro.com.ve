<?php

use Illuminate\Database\Seeder;

class BillingTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de Billing! ***");

    factory(App\Billing::class, 2)->create();

    $this->command->info('Creacion de billing completada.');
  }

}
