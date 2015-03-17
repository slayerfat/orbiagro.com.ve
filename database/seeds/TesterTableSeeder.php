<?php

use Illuminate\Database\Seeder;

class TesterTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $gender = App\Gender::where('description', 'Masculino')->first();
    $parish = App\Parish::find(1);
    $nationality = App\Nationality::where('description', 'Venezolano')->first();
    $admin = App\Profile::where('description', 'Administrador')->first();
    $tester = DB::table('users')->insert([
      'name'       => 'tester',
      'email'      => 'tester@tester.com',
      'password'   => Hash::make('tester'),
      'profile_id' => $admin->id,
      'created_at' => 'current_timestampt',
      'updated_at' => 'current_timestampt'
    ]);

    $tester = App\User::where('name', 'tester')->first();

    $person = DB::table('people')->insert([
      'user_id'        => $tester->id,
      'gender_id'      => $gender->id,
      'nationality_id' => $nationality->id,
      'first_name'     => 'tester',
      'first_surname'  => 'tester',
      'identity_card'  => '10000001',
      'phone'          => '+58-(212)-111-2233',
      'birth_date'     => '1999-09-09',
      'created_at'     => 'current_timestampt',
      'updated_at'     => 'current_timestampt'
    ]);

    $direction = new App\Direction;

    $direction->parish_id  = $parish->id;
    $direction->details    = 'Calle del tester.';
    $direction->created_by = $tester->id;
    $direction->updated_by = $tester->id;

    $tester->person->direction()->save($direction);

    $this->command->info('--- SOLO PARA PRUEBAS ---');
  }

}
