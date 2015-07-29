<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\Visit;

class VisitTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de Visits! ***");

    $user = User::first();
    $product = Product::first();
    $visit = new Visit;
    $visit->user_id = $user->id;
    $visit->total = 1;
    $visit->created_by = $user->id;
    $visit->updated_by = $user->id;
    $product->visits()->save($visit);

    $this->command->info('Creacion de visita completada.');
  }

}
