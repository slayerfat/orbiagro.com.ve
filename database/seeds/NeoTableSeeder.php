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
    $gender = App\Gender::where('description', 'Masculino')->first();
    $nationality = App\Nationality::where('description', 'Extrangero')->first();
    $admin = App\Profile::where('description', 'Administrador')->first();
    $neo = App\User::create([
      'name'       => env('APP_USER'),
      'email'      => env('APP_USER_EMAIL'),
      'password'   => Hash::make( env('APP_USER_PASSWORD') ),
      'profile_id' => $admin->id
    ]);

    $person = DB::table('people')->insert([
      'user_id'        => $neo->id,
      'gender_id'      => $gender->id,
      'nationality_id' => $nationality->id,
      'first_name'     => 'Keanu',
      'first_surname'  => 'Reaves',
      'identity_card'  => '10000000',
      'phone'          => '+58-(212)-333-2211',
      'birth_date'     => '1968-09-06'
    ]);

    $this->command->info('EL ELEGIDO EXISTE EN EL SISTEMA!');
  }

}
