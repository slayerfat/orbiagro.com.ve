<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\Visit;

class VisitTableSeeder extends Seeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Visits! ***");

        $product = Product::first();

        factory(App\Visit::class, 3)->make()->each(function ($visit) use ($product) {
            $product->visits()->save($visit);
        });

        $this->command->info('Creacion de visita completada.');
    }
}
