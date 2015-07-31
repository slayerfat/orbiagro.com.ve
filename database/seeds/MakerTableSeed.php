<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\User;
use App\Image;

class MakerTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Maker! ***");
        //
        // // se empieza creado el directorio relacionado con el producto
        // // primero se elimina si existe
        // Storage::disk('public')->deleteDirectory("makers/{$maker->id}");
        // Storage::disk('public')->makeDirectory("makers/{$maker->id}");
        //
        // // el nombre del archivo
        // $name = date('Ymdhmmss-').str_random(20);
        // // se copia el archivo
        // Storage::disk('public')->copy('1500x1500.gif', "makers/{$maker->id}/{$name}.gif");
        // $this->command->info("Creado makers/{$maker->id}/{$name}.gif");
        //
        // // el modelo
        // $image             = new Image;
        // $image->path       = "makers/{$maker->id}/{$name}.gif";
        // $image->mime       = 'image/gif';
        // $image->alt        = $maker->slug;
        // $image->created_by = $user->id;
        // $image->updated_by = $user->id;
        // $maker->image()->save($image);
    $this->command->info('Creacion de compañias completa.');
  }

}
