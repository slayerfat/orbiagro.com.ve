<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\Product;

class PurchaseTableSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Purchases! ***");

        $products = Product::all();

        foreach ($products as $product) {
            $this->user->purchases()->attach($product->id, ['quantity' => rand(1, 5)]);
        }

        $this->command->info('Creado compras.');
    }
}
