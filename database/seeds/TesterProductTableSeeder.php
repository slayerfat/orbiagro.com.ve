<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\SubCategory;
use App\Maker;
use App\Parish;
use App\Direction;
use App\MapDetail;
use App\Product;

class TesterProductTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker  = Faker::create('es_ES');
    $subcat = SubCategory::all();
    $user   = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($subcat as $subcategory):
      $this->command->info('en bucle de subcat: '.$subcategory->slug);
      $maker   = Maker::orderByRaw('RANDOM()')->first();
      $parish  = Parish::orderByRaw('RANDOM()')->first();
      $title   = $faker->sentence(5);
      // fix build #202
      $product = new Product;
      $product->user_id         = $user->id;
      $product->maker_id        = $maker->id;
      $product->sub_category_id = $subcategory->id;
      $product->title           = $title;
      $product->description     = $faker->text();
      $product->price           = $faker->randomFloat(2, 100, 9999999999);
      $product->quantity        = $faker->randomDigitNotNull();
      $product->slug            = str_slug($title);
      $product->created_by      = $user->id;
      $product->updated_by      = $user->id;
      $product->save();

      $this->command->info("Producto {$product->title} creado!");
      $direction = new Direction;
      $direction->parish_id  = $parish->id;
      $direction->details    = $faker->streetAddress();
      $direction->created_by = $user->id;
      $direction->updated_by = $user->id;
      $product->direction()->save($direction);
      $this->command->info("direccion: {$direction->details}");
    endforeach;
    // para asegurarse que un producto tenga un maker de id 1
    $subcategory = SubCategory::first();
    $maker   = Maker::first();
    $this->command->info('producto final: '.$subcategory->slug);
    // para asegurarse que un producto tenga un parish de id 1
    $parish  = Parish::first();
    $title   = $faker->sentence(5);
    // fix build #202
    $product->user_id         = $user->id;
    $product->maker_id        = $maker->id;
    $product->sub_category_id = $subcategory->id;
    $product->title           = $title;
    $product->description     = $faker->text();
    $product->price           = $faker->randomFloat(2, 100, 9999999999);
    $product->quantity        = $faker->randomDigitNotNull();
    $product->slug            = str_slug($title);
    $product->created_by      = $user->id;
    $product->updated_by      = $user->id;
    $product->save();

    $this->command->info("Producto {$product->title} creado!");
    $direction = new Direction;
    $direction->parish_id  = $parish->id;
    $direction->details    = $faker->streetAddress();
    $direction->created_by = $user->id;
    $direction->updated_by = $user->id;
    $product->direction()->save($direction);
    $this->command->info("direccion: {$direction->details}");

    // detalles del mapa
    $this->command->info("map details: 10.492315, -66.932899");
    $map = new MapDetail;
    $map->latitude   = 10.492315;
    $map->longitude  = -66.932899;
    $map->zoom       = 12;
    $map->created_by = $user->id;
    $map->updated_by = $user->id;
    $direction->map()->save($map);

    $this->command->info('Creacion de productos completado.');
  }

}
