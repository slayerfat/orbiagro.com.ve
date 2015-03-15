<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\SubCategory;
use App\Image;
use App\File;
use App\Maker;
use App\Product;

class FeatureTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $file   = new File;
    $faker  = Faker::create('es_ES');
    $user   = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    $products = Product::all();

    foreach($products as $product):
      $this->command->info("Producto {$product->slug}");
      foreach(range(1, 5) as $index) :
        $this->command->info("feature {$index}");
        $feature              = new App\Feature;
        $feature->title       = $faker->sentence(3);
        $feature->description = $faker->text(100);
        $feature->created_by  = $user->id;
        $feature->updated_by  = $user->id;

        $product->features()->save($feature);

        // se empieza creado el directorio relacionado con el producto
        // primero se elimina si existe
        Storage::deleteDirectory("products/{$product->id}");
        Storage::makeDirectory("products/{$product->id}");
        // el nombre del archivo
        $name = date('Ymdhmmss-').'1500x1500.gif';
        // se copia el archivo
        Storage::copy('1500x1500.gif', "products/{$product->id}/{$name}");
        $this->command->info("Creada carpeta products/{$product->id}/{$name}");
        // se ajusta el modelo
        $image  = new Image;
        $image->path = "products/{$product->id}/{$name}";
        $image->alt  = $feature->title;
        $image->created_by  = $user->id;
        $image->updated_by  = $user->id;
        // se guarda
        $feature->images()->save($image);
      endforeach;
    endforeach;
    $this->command->info('Creacion de productos completado.');
  }

}
