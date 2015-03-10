<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $types = [
      'Masculino',
      'Femenino'
    ];

    foreach($types as $gender):
      App\Gender::create([
        'description' => $gender
      ]);
    endforeach;
    $this->command->info('El Elegido necesita un Genero...');
  }

}
