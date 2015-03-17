<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\SubCategory;
use App\Maker;
use App\Parish;
use App\Direction;
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
      if(rand(0,1)):
        $maker   = Maker::orderByRaw('RANDOM()')->first();
        $parish  = Parish::orderByRaw('RANDOM()')->first();
        $product = Product::create([
          'user_id'     => $user->id,
          'maker_id'    => $maker->id,
          'title'       => $faker->sentence(5),
          'description' => $faker->text(),
          'price'       => $faker->randomFloat(2, 100, 9999999999),
          'quantity'    => $faker->numberBetween(1, 20),
          'slug'        => true,
          'created_by'  => $user->id,
          'updated_by'  => $user->id,
        ]);
        $this->command->info("Producto {$product->title} creado!");
        $direction = new Direction;
        $direction->parish_id  = $parish->id;
        $direction->details    = $faker->streetAddress();
        $direction->created_by = $user->id;
        $direction->updated_by = $user->id;
        $product->direction()->save($direction);
        $this->command->info("direccion: {$direction->details}");
        $product->sub_categories()->attach($subcategory->id);
      endif;
    endforeach;
    $this->command->info('Creacion de productos completado.');
  }

}
