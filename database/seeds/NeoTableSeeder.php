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
    $parish = App\Parish::find(1);
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

    $neo = App\User::where('name', env('APP_USER'))->first();
    $direction = new App\Direction;

    $direction->parish_id  = $parish->id;
    $direction->details    = 'Av. Tal, Calle tal.';
    $direction->created_by = $neo->id;
    $direction->updated_by = $neo->id;

    $neo->person->direction()->save($direction);

    $this->command->info('EL ELEGIDO EXISTE EN EL SISTEMA!');
  }

}
