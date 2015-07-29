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
    $this->command->info('--- SOLO PARA PRUEBAS ---');
    $this->command->info('--- TESTER ---');

    $gender      = App\Gender::where('description', 'Masculino')->first();
    $parish      = App\Parish::find(1);
    $nationality = App\Nationality::where('description', 'Venezolano')->first();
    $profile     = App\Profile::where('description', 'Administrador')->first();

    // fix build #202
    $tester = App\User::where('name', 'tester')->first();

    $person = new App\Person;
    $person->user_id        = $tester->id;
    $person->gender_id      = $gender->id;
    $person->nationality_id = $nationality->id;
    $person->first_name     = 'tester';
    $person->first_surname  = 'tester';
    $person->identity_card  = '10000001';
    $person->phone          = '+58-(212)-111-2233';
    $person->birth_date     = '1999-09-09';
    $person->created_at     = Carbon\Carbon::now();
    $person->updated_at     = Carbon\Carbon::now();
    $person->created_by     = $user->id;
    $person->updated_by     = $user->id;
    $tester->person()->save($person);

    $direction = new App\Direction;

    $direction->parish_id  = $parish->id;
    $direction->details    = 'Calle del tester.';
    $direction->created_by = $tester->id;
    $direction->updated_by = $tester->id;

    $tester->person->direction()->save($direction);

    $this->command->info('--- DUMMY ---');
    $profile = App\Profile::where('description', 'Usuario')->first();

    $tester = new App\User;
    $tester->name       = 'dummy';
    $tester->email      = 'dummy@tester.com';
    $tester->password   = Hash::make('dummypw');
    $tester->profile_id = $profile->id;
    $tester->created_at = Carbon\Carbon::now();
    $tester->updated_at = Carbon\Carbon::now();
    $tester->save();

    $tester = App\User::where('name', 'dummy')->first();

    $person = new App\Person;
    $person->user_id        = $tester->id;
    $person->gender_id      = $gender->id;
    $person->nationality_id = $nationality->id;
    $person->first_name     = 'dummy';
    $person->first_surname  = 'dummy';
    $person->identity_card  = '10000002';
    $person->phone          = '+58-(212)-444-5566';
    $person->birth_date     = '1999-09-09';
    $person->created_at     = Carbon\Carbon::now();
    $person->updated_at     = Carbon\Carbon::now();
    $person->created_by     = $user->id;
    $person->updated_by     = $user->id;
    $tester->person()->save($person);

    $direction = new App\Direction;

    $direction->parish_id  = $parish->id;
    $direction->details    = 'Calle del dummy.';
    $direction->created_by = $tester->id;
    $direction->updated_by = $tester->id;

    $tester->person->direction()->save($direction);

    $this->command->info('--- SOLO PARA PRUEBAS ---');
  }

}
