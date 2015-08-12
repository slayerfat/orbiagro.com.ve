<?php

use Illuminate\Database\Seeder;

use App\Mamarrachismo\Upload\Image as Upload;

class PromotionTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de Promotion! ***");

    // upload necesita el ID del usuario a asociar.
    $this->upload = new Upload(1);

    $product = App\Product::first();

    factory(App\Promotion::class, 3)->create()->each(function($promo) use($product){
      $this->upload->createImage(null, $promo);
      $product->promotions()->attach($promo);
    });


  }

}
