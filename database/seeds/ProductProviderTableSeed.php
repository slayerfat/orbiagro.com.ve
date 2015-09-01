<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\Product;
use Orbiagro\Models\Provider;

class ProductProviderTableSeed extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de ProductProvider! ***");

        $product  = Product::first();
        $provider = Provider::first();

        $product->providers()->attach($provider->id, ['sku' => rand(1, 50000)]);

        $this->command->info('ProductProvider completados.');
    }
}
