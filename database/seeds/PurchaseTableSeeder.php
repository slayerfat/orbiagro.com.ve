<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;

class PurchaseTableSeeder extends Seeder {

  public function run()
  {
    $user    = User::first();
    $products = Product::all();

    foreach($products as $product):
      $user->purchases()->attach($product->id, ['quantity' => rand(1, 5)]);
    endforeach;
    $this->command->info('Creado compras.');
  }

}
