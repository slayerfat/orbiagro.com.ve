<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Provider;

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
