<?php

use Illuminate\Database\Seeder;

class NationalityTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $types = [
      'Venezolano',
      'Extrangero'
    ];

    foreach($types as $type):
      App\Nationality::create([
        'description' => $type
      ]);
    endforeach;
    $this->command->info('El Elegido necesita una Nacionalidad...');
  }

}
