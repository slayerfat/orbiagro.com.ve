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
      $product = Product::create([
        'user_id'         => $user->id,
        'maker_id'        => $maker->id,
        'sub_category_id' => $subcategory->id,
        'title'           => $title,
        'description'     => $faker->text(),
        'price'           => $faker->randomFloat(2, 100, 9999999999),
        'quantity'        => $faker->numberBetween(1, 20),
        'slug'            => str_slug($title),
        'created_by'      => $user->id,
        'updated_by'      => $user->id,
      ]);
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
    $product = Product::create([
      'user_id'         => $user->id,
      'maker_id'        => $maker->id,
      'sub_category_id' => $subcategory->id,
      'title'           => $title,
      'description'     => $faker->text(),
      'price'           => $faker->randomFloat(2, 100, 9999999999),
      'quantity'        => $faker->numberBetween(1, 20),
      'slug'            => str_slug($title),
      'created_by'      => $user->id,
      'updated_by'      => $user->id,
    ]);
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
    $map->latitude = 10.492315;
    $map->longitude = -66.932899;
    $map->zoom = 12;
    $direction->map()->save($map);

    $this->command->info('Creacion de productos completado.');
  }

}
