<?php

use Illuminate\Database\Seeder;

class NeoTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $admin = App\Profile::where('description', 'Administrador')->first();
    App\User::create([
      'name'       => env('APP_USER'),
      'email'      => env('APP_USER_EMAIL'),
      'password'   => Hash::make( env('APP_USER_PASSWORD') ),
      'profile_id' => $admin->id
    ]);

    $this->command->info('EL ELEGIDO EXISTE EN EL SISTEMA!');
  }

}
