<?php

use Illuminate\Database\Seeder;

use App\Mamarrachismo\Upload;

class ProductTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Product! ***");

    // upload necesita el ID del usuario a asociar.
    $upload = new Upload(1);

    App\User::all()->each(function($user) use($upload){
      factory(App\Product::class, 20)->make()->each(function($product) use($upload, $user){
        $user->products()->save($product);
        $this->command->info("--- guardado producto {$product->title} ---");
        $product->direction()->save(factory(App\Direction::class)->make());
        $product->direction()
                ->first()
                ->map()
                ->save(factory(App\MapDetail::class)->make());
        $upload->createImage(null, $product);
      });
    });
  }

}
