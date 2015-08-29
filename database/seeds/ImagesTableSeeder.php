<?php

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

        $dir = class_basename(Orbiagro\Models\Product::class);

        $dir = strtolower($dir);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory($dir);
        Storage::disk('public')->makeDirectory($dir);

        foreach ($products as $product) {
            $this->command->info("Producto {$product->slug}");
            // el nombre del archivo
            $name = date('Ymdhmmss-').str_random(20);
            // se copia el archivo
            Storage::disk('public')->copy('1500x1500.gif', "{$dir}/{$product->id}/{$name}.gif");
            $this->command->info("Creado {$dir}/{$product->id}/{$name}.gif");

            // el modelo
            $image             = new Image;
            $image->path       = "{$dir}/{$product->id}/{$name}.gif";
            $image->original   = $image->path;
            $image->mime       = 'image/gif';
            $image->alt        = $product->title;
            $image->created_by = $this->user->id;
            $image->updated_by = $this->user->id;

            $product->images()->save($image);

            // el archivo asociado
            $name = date('Ymdhmmss-').str_random(20);
            Storage::disk('public')->copy('file.pdf', "{$dir}/{$product->id}/{$name}.pdf");
            $this->command->info("Creado {$dir}/{$product->id}/{$name}.pdf");

            // el modelo
            $file             = new File;
            $file->path       = "{$dir}/{$product->id}/{$name}.pdf";
            $file->mime       = "application/pdf";
            $file->created_by = $this->user->id;
            $file->updated_by = $this->user->id;

            $product->files()->save($file);
        }

        $this->command->info('Creacion de images y archivos de producto completado.');
    }
}
