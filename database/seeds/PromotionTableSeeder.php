<?php

use Illuminate\Database\Seeder;

use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class PromotionTableSeeder extends Seeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Promotion! ***");

        // upload necesita el ID del usuario a asociar.
        $this->upload = new Upload(1);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory('promos');
        Storage::disk('public')->makeDirectory('promos');

        $product = Orbiagro\Models\Product::first();

        factory(Orbiagro\Models\Promotion::class, 'realRelations', 3)->create()->each(function ($promo) use ($product) {
            $this->command->info("Promotion: {$promo->title}");

            $this->upload->create($promo);

            $product->promotions()->attach($promo);
        });
    }
}
