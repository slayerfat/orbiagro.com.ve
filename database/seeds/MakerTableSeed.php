<?php

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

        $dir = class_basename(Orbiagro\Models\Maker::class);

        $dir = strtolower($dir);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory($dir);
        Storage::disk('public')->makeDirectory($dir);

        factory(Orbiagro\Models\Maker::class, 2)->create()->each(function ($model) use ($upload) {
            $upload->create($model);
        });
    }
}
