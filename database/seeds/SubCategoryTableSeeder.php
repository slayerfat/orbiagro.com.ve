<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\User;

class SubCategoryTableSeeder extends Seeder {

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

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($types as $category => $values):
      $this->command->info("$category");

      $cat = App\Category::where('description', $category)->first();
        foreach($values as $value):
          $this->command->info("$value");
          App\SubCategory::create([
            'category_id' => $cat->id,
            'description' => $value,
            'info'        => $faker->text(),
            'slug'        => str_slug($value, '-'),
            'created_by'  => $user->id,
            'updated_by'  => $user->id,
          ]);
        endforeach;
    endforeach;
    $this->command->info('El Elegido creo las sub-categorias.');
  }

}
