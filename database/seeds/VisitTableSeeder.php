<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\User;
use Orbiagro\Models\Product;
use Orbiagro\Models\Visit;

class VisitTableSeeder extends Seeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Visits! ***");

        $product = Product::first();

        factory(Orbiagro\Models\Visit::class, 3)->make()->each(function ($visit) use ($product) {
            $product->visits()->save($visit);
        });

        $this->command->info('Creacion de visita completada.');
    }
}
