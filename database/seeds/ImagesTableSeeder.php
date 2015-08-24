<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\Image;
use Orbiagro\Models\File;
use Orbiagro\Models\Product;

class ImagesTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Images! ***");

        $products = Product::all();

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory('products');
        Storage::disk('public')->makeDirectory('products');

        foreach ($products as $product) {
            $this->command->info("Producto {$product->slug}");
            // el nombre del archivo
            $name = date('Ymdhmmss-').str_random(20);
            // se copia el archivo
            Storage::disk('public')->copy('1500x1500.gif', "products/{$product->id}/{$name}.gif");
            $this->command->info("Creado products/{$product->id}/{$name}.gif");

            // el modelo
            $image             = new Image;
            $image->path       = "products/{$product->id}/{$name}.gif";
            $image->original   = $image->path;
            $image->mime       = 'image/gif';
            $image->alt        = $product->title;
            $image->created_by = $this->user->id;
            $image->updated_by = $this->user->id;

            $product->images()->save($image);

            // el archivo asociado
            $name = date('Ymdhmmss-').str_random(20);
            Storage::disk('public')->copy('file.pdf', "products/{$product->id}/{$name}.pdf");
            $this->command->info("Creado products/{$product->id}/{$name}.pdf");

            // el modelo
            $file             = new File;
            $file->path       = "products/{$product->id}/{$name}.pdf";
            $file->mime       = "application/pdf";
            $file->created_by = $this->user->id;
            $file->updated_by = $this->user->id;

            $product->files()->save($file);
        }

        $this->command->info('Creacion de images y archivos de producto completado.');
    }
}
