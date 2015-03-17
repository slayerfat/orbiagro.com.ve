<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $types = [
      'Productos Agro-Industriales',
      'Productos Alimenticios'
    ];

    foreach($types as $category):
      $category = App\Category::create([
        'description' => $category,
        'slug'        => str_slug($category, '-')
      ]);
    endforeach;
    $this->command->info('El Elegido creo las categorias.');
  }

}
