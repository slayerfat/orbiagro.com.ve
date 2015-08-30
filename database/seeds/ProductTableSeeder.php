<?php

use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class ProductTableSeeder extends BaseSeeder
{

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

        $this->createDirectory(Orbiagro\Models\Product::class);

        // por cada usuario en el sistema, se pretende
        // crear algunos productos con sus caracteristicas particulares.
        Orbiagro\Models\User::all()->each(function ($user) {
            // es necesario hacer esto por cada producto.
            factory(Orbiagro\Models\Product::class, 'realRelations', 3)->make()->each(function ($product) use ($user) {
                // se guarda el producto en la base de datos.
                $user->products()->save($product);
                $this->command->info("--- guardado producto {$product->title} ---");

                // luego se guarda la direccion.
                $product->direction()->save(factory(Orbiagro\Models\Direction::class)->make());

                // con la direccion se guardan los detalles del mapa.
                $product->direction()
                    ->first()
                    ->map()
                    ->save(factory(Orbiagro\Models\MapDetail::class)->make());

                // se guarda la imagen del producto
                // por estar nulo el primer argumento, saldra una
                // imagen por defecto, -sin imagen-
                $this->upload->create($product);

                // como los features tienen una imagen asociada
                // se guarda la instancia como variable $f
                // y se guarda una imagen.
                $f = $product->features()->save(factory(Orbiagro\Models\Feature::class)->make());

                $this->upload->create($f);

                // estos son el resto de las entidades relacionadas con producto.
                $product->characteristics()->save(factory(Orbiagro\Models\Characteristic::class)->make());
                $product->nutritional()->save(factory(Orbiagro\Models\Nutritional::class)->make());
                $product->mechanical()->save(factory(Orbiagro\Models\MechanicalInfo::class)->make());
            });
        });
    }
}
