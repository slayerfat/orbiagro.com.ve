<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

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

    $faker  = Faker::create('es_ES');

    foreach($types as $category):
      $category = App\Category::create([
        'description' => $category,
        'info'        => $faker->text(),
        'slug'        => str_slug($category, '-')
      ]);
    endforeach;
    $this->command->info('El Elegido creo las categorias.');
  }

}
