<?php

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
            ],
            'Industria Minera'            => [
                'Minerales Metálicos',
                'Minerales Sulfuros',
                'Minerales Silicatos',
                'Minerales Cuarzos',
                'Minerales Sulfatados',
                'Minerales Carbonados',
                'Minerales Oxidados',
                'Minerales Haluros',
                'Minerales Fosfatos',
                'Minerales Elementales',
                'Mineraloides',
            ]
        ];

        $faker  = Faker::create('es_ES');

        $this->upload = new Upload(1);

        $this->createDirectory(Orbiagro\Models\SubCategory::class);

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
