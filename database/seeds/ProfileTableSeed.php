<?php

use Illuminate\Database\Seeder;

class ProfileTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $types = [
      'Administrador',
      'Usuario',
      'Desactivado'
    ];

    foreach($types as $profile):
      App\Profile::create([
        'description' => $profile
      ]);
    endforeach;
    $this->command->info('El Elegido necesita un perfil...');
  }

}
