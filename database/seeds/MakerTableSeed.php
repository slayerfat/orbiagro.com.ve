<?php

use Illuminate\Database\Seeder;

use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class MakerTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Maker! ***");

        // upload necesita el ID del usuario a asociar.
        $upload = new Upload(1);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory('makers');
        Storage::disk('public')->makeDirectory('makers');

        factory(App\Maker::class, 2)->create()->each(function ($model) use ($upload) {
            $upload->createImage($model);
        });
    }
}
