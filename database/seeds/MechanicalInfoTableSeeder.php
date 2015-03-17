<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Product;
use App\MechanicalInfo;

class MechanicalInfoTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker  = Faker::create('es_ES');
    $user   = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    $products = Product::all();

    foreach($products as $product):
      $this->command->info("Producto {$product->slug}");
      MechanicalInfo::create([
        'product_id'   => $product->id,
        'motor'        => 1,
        'motor_serial' => 1,
        'model'        => 1,
        'cylinders'    => 1,
        'horsepower'   => 1,
        'mileage'      => 1,
        'traction'     => 1,
        'lift'         => 1,
        'created_by'   => $user->id,
        'updated_by'   => $user->id,
      ]);
    endforeach;
    $this->command->info('Creacion de info mechanico completado.');
  }

}
