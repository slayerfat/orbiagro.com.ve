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
    $this->upload = new Upload(1);

    // por cada usuario en el sistema, se pretende
    // crear algunos productos con sus caracteristicas particulares.
    App\User::all()->each(function($user){
      // es necesario hacer esto por cada producto.
      factory(App\Product::class, 20)->make()->each(function($product) use($user){

        // se guarda el producto en la base de datos.
        $user->products()->save($product);
        $this->command->info("--- guardado producto {$product->title} ---");

        // luego se guarda la direccion.
        $product->direction()->save(factory(App\Direction::class)->make());

        // con la direccion se guardan los detalles del mapa.
        $product->direction()
                ->first()
                ->map()
                ->save(factory(App\MapDetail::class)->make());

        // se guarda la imagen del producto
        // por estar nulo el primer argumento, saldra una
        // imagen por defecto, -sin imagen-
        $this->upload->createImage(null, $product);

        // como los features tienen una imagen asociada
        // se guarda la instancia como variable $f
        // y se guarda una imagen.
        $f = $product->features()->save(factory(App\Feature::class)->make());
        $this->upload->createImage(null, $f);

        // estos son el resto de las entidades relacionadas con producto.
        $product->characteristics()->save(factory(App\Characteristic::class)->make());
        $product->nutritional()->save(factory(App\Nutritional::class)->make());
        $product->mechanical()->save(factory(App\MechanicalInfo::class)->make());
      });
    });
  }
}
