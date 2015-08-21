<?php

use Illuminate\Database\Seeder;

use App\Mamarrachismo\Upload\Image as Upload;

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

        App\Product::all()->each(function ($product) {
            $f = $product->features()->save(factory(App\Feature::class)->make());
            $this->upload->createImage($f);
        });

        $this->command->info('Creacion de features completado.');
    }
}
