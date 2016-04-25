<?php

use Orbiagro\Mamarrachismo\Upload\Image as Upload;
use Orbiagro\Models\Category;

class SubCategoryTableSeeder extends BaseSeeder
{

    /**
     * @var array
     */
    private $types = [
        'Productos Agro-Industriales' => [
            [
                'desc' => 'Maquinaria Pesada',
                'url'  => 'http://i.imgur.com/h6rRFld.jpg',
                'temp' => 'cat-maquinaria-pesada.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Maquinaria Ligera',
                'url'  => 'http://i.imgur.com/oqLiHeo.jpg',
                'temp' => 'cat-maquinaria-ligera.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Tractores',
                'url'  => 'http://i.imgur.com/KFc3aey.jpg',
                'temp' => 'cat-tractores.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
        ],
        'Productos Alimenticios'      => [
            [
                'desc' => 'Chocolate',
                'url'  => 'http://i.imgur.com/ShltemU.jpg',
                'temp' => 'cat-chocolate.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Arroz',
                'url'  => 'http://i.imgur.com/NUyeKKg.jpg',
                'temp' => 'cat-arroz.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Avena',
                'url'  => 'http://i.imgur.com/KOh61nH.jpg',
                'temp' => 'cat-avena.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Soya',
                'url'  => 'http://i.imgur.com/lpVoEDZ.jpg',
                'temp' => 'cat-soya.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
        ],
        'Industria Minera'            => [
            [
                'desc' => 'Minerales Metálicos',
                'url'  => 'http://i.imgur.com/rM8g36k.jpg',
                'temp' => 'cat-minerales-metalicos.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Sulfuros',
                'url'  => 'http://i.imgur.com/n33xlU6.jpg',
                'temp' => 'cat-minerales-sulfuros.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Silicatos',
                'url'  => 'http://i.imgur.com/QkMjPow.jpg',
                'temp' => 'cat-minerales-silicatos.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Cuarzos',
                'url'  => 'http://i.imgur.com/9wgNdNI.jpg',
                'temp' => 'cat-minerales-cuarzos.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Sulfatados',
                'url'  => 'http://i.imgur.com/0x0Nsgp.jpg',
                'temp' => 'cat-minerales-sulfatados.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Carbonados',
                'url'  => 'http://i.imgur.com/C1ku7id.jpg',
                'temp' => 'cat-minerales-carbonados.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Mineraloides',
                'url'  => 'http://i.imgur.com/grFVQ0r.jpg',
                'temp' => 'cat-mineraloides.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Elementales',
                'url'  => 'http://i.imgur.com/Ly0XnKj.jpg',
                'temp' => 'cat-minerales-elementales.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Fosfatos',
                'url'  => 'http://i.imgur.com/bpb9wSK.jpg',
                'temp' => 'cat-minerales-fosfatos.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Haluros',
                'url'  => 'http://i.imgur.com/dh35cxt.jpg',
                'temp' => 'cat-minerales-haluros.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
            [
                'desc' => 'Minerales Óxidos',
                'url'  => 'http://i.imgur.com/zunC4XR.jpg',
                'temp' => 'cat-minerales-oxidos.jpg',
                'mime' => 'image/jpeg',
                'ext'  => 'jpg',
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("*** Empezando creacion de SubCategory! ***");

        $this->upload = new Upload(1);

        $this->createDirectory(Orbiagro\Models\SubCategory::class);

        foreach ($this->types as $category => $values) {
            $this->command->comment("$category");

            /** @var Category $cat */
            $cat = Category::where('description', $category)->first();
            foreach ($values as $data) {
                $this->command->info("creando rubro {$data['desc']}");
                $img = $this->createUploadedFileImg($data);

                $this->create($cat, $data, $img);
            }
        }

        $this->command->info('El Elegido creo las sub-categorias.');
    }

    /**
     * @param Category $cat
     * @param array $data
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $img
     */
    protected function create(Category $cat, $data, $img)
    {
        $subCat = Orbiagro\Models\SubCategory::create([
            'category_id' => $cat->id,
            'description' => $data['desc'],
            'info'        => $this->faker->text(),
            'slug'        => str_slug($data['desc'], '-'),
            'created_by'  => $this->user->id,
            'updated_by'  => $this->user->id,
        ]);

        $this->upload->create($subCat, $img);
    }
}
