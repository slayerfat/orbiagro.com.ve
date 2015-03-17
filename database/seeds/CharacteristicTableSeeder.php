<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Product;
use App\Characteristic;

class CharacteristicTableSeeder extends Seeder {

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
      Characteristic::create([
        'product_id' => $product->id,
        'height'     => 1,
        'width'      => 1,
        'depth'      => 1,
        'units'      => 1,
        'weight'     => 1,
        'created_by' => $user->id,
        'updated_by' => $user->id,
      ]);
    endforeach;
    $this->command->info('Creacion de caracteristicas completada.');
  }

}
