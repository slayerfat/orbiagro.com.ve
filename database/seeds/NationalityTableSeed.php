<?php

use Illuminate\Database\Seeder;

use App\User;

class NationalityTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Nationality! ***");
    $types = [
      'Venezolano',
      'Extrangero'
    ];

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($types as $type):
      App\Nationality::create([
        'description' => $type,
        'created_by' => $user->id,
        'updated_by' => $user->id,
      ]);
    endforeach;
    $this->command->info('El Elegido necesita una Nacionalidad...');
  }

}
