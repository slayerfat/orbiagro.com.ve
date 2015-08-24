<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class CategoryTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Category! ***");

        $types = [
            'Productos Agro-Industriales',
            'Productos Alimenticios'
        ];

        $faker  = Faker::create('es_ES');

        $this->upload = new Upload(1);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory('category');
        Storage::disk('public')->makeDirectory('category');

        foreach ($types as $category) {
            $category = App\Category::create([
                'description' => $category,
                'info'        => $faker->text(),
                'slug'        => str_slug($category, '-'),
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);
            $this->upload->createImage($category);
        }

        $this->command->info('El Elegido creo las categorias.');
    }
}
