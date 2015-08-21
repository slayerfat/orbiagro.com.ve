<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Characteristic;

class CharacteristicTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Characteristics! ***");

        $products = Product::all();

        foreach ($products as $product) {
            $this->command->info("Producto {$product->slug}");
            Characteristic::create([
                'product_id' => $product->id,
                'height'     => 1,
                'width'      => 1,
                'depth'      => 1,
                'units'      => 1,
                'weight'     => 1,
                'created_by' => $this->user->id,
                'updated_by' => $this->user->id,
            ]);
        }

        $this->command->info('Creacion de caracteristicas completada.');
    }
}
