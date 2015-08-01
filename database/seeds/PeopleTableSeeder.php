<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Person;

class PeopleTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion People para APP_USER ***");

    $user = User::where('name', env('APP_USER'))->firstOrFail();

    $person = Person::create([
      'user_id'        => $user->id,
      'gender_id'      => 1,
      'nationality_id' => 1,
      'first_name'     => 'Keanu',
      'first_surname'  => 'Reaves',
      'identity_card'  => '10000000',
      'phone'          => '2123332211',
      'birth_date'     => '1968-09-06',
      'created_at'     => Carbon\Carbon::now(),
      'updated_at'     => Carbon\Carbon::now(),
      'created_by'     => $user->id,
      'updated_by'     => $user->id,
    ]);

    $direction = new App\Direction;

    $direction->parish_id  = 1;
    $direction->details    = 'Av. Tal, Calle tal.';
    $direction->created_by = $user->id;
    $direction->updated_by = $user->id;

    $person->direction()->save($direction);

    $this->command->info('Terminado People para APP_USER');
  }

}