<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Orbiagro\Models\User;
use Orbiagro\Models\SubCategory;
use Orbiagro\Models\Image;
use Orbiagro\Models\File;
use Orbiagro\Models\Maker;
use Orbiagro\Models\Product;

class TesterFeatureTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de TESTER: Feature! ***");

        $user   = User::where('name', 'tester')->first();

        if (!$user) $user = User::where('name', env('APP_USER'))->first();

        $products = Product::all();

        foreach ($products as $product) {
            $this->command->info("Producto {$product->slug}");
            foreach (range(1, 2) as $index) {
                $this->command->info("feature {$index}");
                $feature              = new Orbiagro\Models\Feature;
                $feature->title       = 'tester';
                $feature->description = 'tester';
                $feature->created_by  = $user->id;
                $feature->updated_by  = $user->id;

                $product->features()->save($feature);

                // se empieza creado el directorio relacionado con el producto
                // primero se elimina si existe
                Storage::disk('test')->deleteDirectory("products/{$product->id}");
                Storage::disk('test')->makeDirectory("products/{$product->id}");

                // el nombre del archivo
                $name = date('Ymdhmmss-').str_random(20);
                // se copia el archivo
                Storage::disk('test')->copy('1500x1500.gif', "products/{$product->id}/{$name}.gif");
                $this->command->info("Creado products/{$product->id}/{$name}.gif");

                // el modelo
                $image             = new Image;
                $image->path       = "products/{$product->id}/{$name}.gif";
                $image->original   = $image->path;
                $image->mime       = 'image/gif';
                $image->alt        = $feature->title;
                $image->created_by = $user->id;
                $image->updated_by = $user->id;
                $feature->image()->save($image);

                // el archivo asociado
                $name = date('Ymdhmmss-').str_random(20);
                Storage::disk('test')->copy('file.pdf', "products/{$product->id}/{$name}.pdf");
                $this->command->info("Creado products/{$product->id}/{$name}.pdf");

                // el modelo
                $file             = new File;
                $file->path       = "products/{$product->id}/{$name}.pdf";
                $file->mime       = "application/pdf";
                $file->created_by = $user->id;
                $file->updated_by = $user->id;
                $feature->file()->save($file);
            }
        }
        $this->command->info('Creacion de productos completado.');
    }
}
