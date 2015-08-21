<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\MechanicalInfo;

class MechanicalInfoTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de MechanicalInfo! ***");

        $products = Product::all();

        foreach ($products as $product) {
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
                'created_by'   => $this->user->id,
                'updated_by'   => $this->user->id,
            ]);
        }

        $this->command->info('Creacion de info mechanico completado.');
    }
}
