<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\SubCategory;
use App\Image;
use App\User;

class SubCategoryImageTableSeeder extends Seeder {

  public function run()
  {
    $cats  = SubCategory::all();
    $faker = Faker::create('es_ES');
    $user  = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    // primero se elimina si existe
    Storage::disk('public')->deleteDirectory("sub-category");

    foreach($cats as $cat) :

      // primero se elimina si existe
      Storage::disk('public')->makeDirectory("sub-category/{$cat->id}");

      // el nombre del archivo
      $name = date('Ymdhmmss-').str_random(20);
      // se copia el archivo
      Storage::disk('public')->copy('1500x1500.gif', "sub-category/{$cat->id}/{$name}.gif");
      $this->command->info("Creado sub-category/{$cat->id}/{$name}.gif");

      // el modelo
      $image             = new Image;
      $image->path       = "sub-category/{$cat->id}/{$name}.gif";
      $image->mime       = 'image/gif';
      $image->alt        = $cat->title;
      $image->created_by = $user->id;
      $image->updated_by = $user->id;
      $cat->image()->save($image);
    endforeach;
    $this->command->info("Fin de imagenes de sub-categorias");
  }

}
