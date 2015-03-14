<?php

use Illuminate\Database\Seeder;

class SubCategoryTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
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

    foreach($types as $category => $values):
      $this->command->info("$category");
      $cat = App\Category::where('description', $category)->first();
        foreach($values as $value):
          $this->command->info("$value");
          App\SubCategory::create([
            'category_id' => $cat->id,
            'description' => $value,
            'slug'        => str_slug($value, '-')
          ]);
        endforeach;
    endforeach;
    $this->command->info('El Elegido creo las sub-categorias.');
  }

}
