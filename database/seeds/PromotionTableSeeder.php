<?php

use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class PromotionTableSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Promotion! ***");

        // upload necesita el ID del usuario a asociar.
        $this->upload = new Upload(1);

        $this->createDirectory(Orbiagro\Models\Promotion::class);

        $product = Orbiagro\Models\Product::first();

        factory(Orbiagro\Models\Promotion::class, 'realRelations', 3)->create()->each(function ($promo) use ($product) {
            $this->command->info("Promotion: {$promo->title}");

            $this->upload->create($promo);

            $product->promotions()->attach($promo);
        });
    }
}
