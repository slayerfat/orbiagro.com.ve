<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Image;
use App\User;

class CategoryImageTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de CategoryImage! ***");

    $cats = Category::all();
    $user = User::where('name', 'tester')->first();
    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    // primero se elimina si existe
    Storage::disk('public')->deleteDirectory("category");

    foreach($cats as $cat) :

      // primero se crea el directorio
      Storage::disk('public')->makeDirectory("category/{$cat->id}");

      // el nombre del archivo
      $name = date('Ymdhmmss-').str_random(20);
      // se copia el archivo
      Storage::disk('public')->copy('1500x1500.gif', "category/{$cat->id}/{$name}.gif");
      $this->command->info("Creado category/{$cat->id}/{$name}.gif");

      // el modelo
      $image             = new Image;
      $image->path       = "category/{$cat->id}/{$name}.gif";
      $image->mime       = 'image/gif';
      $image->alt        = $cat->title;
      $image->created_by = $user->id;
      $image->updated_by = $user->id;
      $cat->image()->save($image);
    endforeach;
    $this->command->info("Fin de imagenes de categorias");
  }

}
