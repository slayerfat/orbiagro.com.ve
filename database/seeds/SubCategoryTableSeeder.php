<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Orbiagro\Mamarrachismo\Upload\Image as Upload;

class SubCategoryTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de SubCategory! ***");

        $types = [
            'Productos Agro-Industriales' => [
                'Maquinaria Pesada',
                'Tractores',
                'Maquinaria Ligera'
            ],
            'Productos Alimenticios' => [
                'Chocolate',
                'Arroz',
                'Avena',
                'Soya'
            ]
        ];

        $faker  = Faker::create('es_ES');

        $this->upload = new Upload(1);

        $dir = class_basename(Orbiagro\Models\SubCategory::class);

        $dir = strtolower($dir);

        // se elimina el directorio de todos los archivos
        Storage::disk('public')->deleteDirectory($dir);
        Storage::disk('public')->makeDirectory($dir);

        foreach ($types as $category => $values) {
            $this->command->info("$category");

            $cat = Orbiagro\Models\Category::where('description', $category)->first();
            foreach ($values as $value) {
                $this->command->info("$value");
                $subCat = Orbiagro\Models\SubCategory::create([
                    'category_id' => $cat->id,
                    'description' => $value,
                    'info'        => $faker->text(),
                    'slug'        => str_slug($value, '-'),
                    'created_by'  => $this->user->id,
                    'updated_by'  => $this->user->id,
                ]);

                $this->upload->create($subCat);
            }
        }

        $this->command->info('El Elegido creo las sub-categorias.');
    }
}
