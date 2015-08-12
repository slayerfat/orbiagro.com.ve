<?php

use Illuminate\Database\Seeder;

use App\Mamarrachismo\Upload\Image as Upload;

class MakerTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Maker! ***");

    // upload necesita el ID del usuario a asociar.
    $upload = new Upload(1);

    factory(App\Maker::class, 2)->create()->each(function($model) use($upload){
      $upload->createImage(null, $model);
    });
  }

}
