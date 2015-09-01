<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\Product;
use Orbiagro\Models\Nutritional;

class NutritionalTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Nutritional! ***");

        $products = Product::all();

        foreach ($products as $product) {
            $this->command->info("Producto {$product->slug}");
            Nutritional::create([
                'product_id' => $product->id,
                'due'        => '1999-09-09',
                'created_by' => $this->user->id,
                'updated_by' => $this->user->id,
            ]);
        }
        $this->command->info('Creacion de info nutricional completada.');
    }
}
