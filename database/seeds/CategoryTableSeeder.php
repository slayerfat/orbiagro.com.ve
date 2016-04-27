<?php

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

        $categories = [
            [
                'desc' => 'Productos Agro-Industriales',
                'url'  => 'http://i.imgur.com/5uS19Vj.jpg',
                'temp' => 'cat-productos-agro-industriales.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Productos Alimenticios',
                'url'  => 'http://i.imgur.com/eEcdHIr.jpg',
                'temp' => 'cat-productos-alimenticios.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Industria Minera',
                'url'  => 'http://i.imgur.com/VkwCfen.jpg',
                'temp' => 'cat-industria-minera.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
        ];

        $this->upload = new Upload(1);

        $this->createDirectory(Orbiagro\Models\Category::class);

        foreach ($categories as $data) {
            $this->command->comment("Creando categoria {$data['desc']}");
            $img = $this->createUploadedFileImg($data);
            $this->create($data['desc'], $img);
        }

        $this->command->info('El Elegido creo las categorias.');
    }

    /**
     * Crea el modelo relacionado a la categoria.
     *
     * @param $desc
     * @param null $image
     */
    public function create($desc, $image = null)
    {
        $category = Orbiagro\Models\Category::create([
            'description' => $desc,
            'info'        => $this->faker->text(),
            'slug'        => str_slug($desc, '-'),
            'created_by'  => $this->user->id,
            'updated_by'  => $this->user->id,
        ]);

        $this->upload->create($category, $image);
    }
}
