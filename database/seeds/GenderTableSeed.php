<?php

use Illuminate\Database\Seeder;

use App\User;

class GenderTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Gender! ***");

    $types = [
      'Masculino',
      'Femenino'
    ];

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    foreach($types as $gender):
      App\Gender::create([
        'description' => $gender,
        'created_by'  => $user->id,
        'updated_by'  => $user->id,
      ]);
    endforeach;
    $this->command->info('Generos creados.');
  }

}
