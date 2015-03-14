<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\SubCategory;
use App\Image;
use App\File;
use App\Maker;
use App\Product;

class ProductTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $image  = new Image;
    $file   = new File;
    $faker  = Faker::create('es_ES');
    $subcat = SubCategory::all();
    $user   = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($subcat as $subcategory):
      if (rand(0,1)) :
        $maker = Maker::orderByRaw('rand()')->first();

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

        foreach(range(1, 5) as $index) :
          $feature              = new App\Feature;
          $feature->title       = $faker->sentence(3);
          $feature->description = $faker->text(100);
          $feature->created_by  = $user->id;
          $feature->updated_by  = $user->id;

          $product->features()->save($feature);
          $image->path = $product->id.'1500x1500.gif';
        endforeach;

      endif;
    endforeach;
    $this->command->info('Creacion de productos completado.');
  }

}
