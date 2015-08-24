<?php

use Illuminate\Database\Seeder;

use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class FeatureTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Feature! ***");

        // upload necesita el ID del usuario a asociar.
        $this->upload = new Upload(1);

        Orbiagro\Models\Product::all()->each(function ($product) {
            $f = $product->features()->save(factory(Orbiagro\Models\Feature::class)->make());
            $this->upload->create($f);
        });

        $this->command->info('Creacion de features completado.');
    }
}
