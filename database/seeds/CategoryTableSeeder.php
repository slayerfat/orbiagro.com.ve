<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

use App\User;

class CategoryTableSeeder extends Seeder {

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

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($types as $category):
      $category = App\Category::create([
        'description' => $category,
        'info'        => $faker->text(),
        'slug'        => str_slug($category, '-'),
        'created_by'  => $user->id,
        'updated_by'  => $user->id,
      ]);
    endforeach;
    $this->command->info('El Elegido creo las categorias.');
  }

}
