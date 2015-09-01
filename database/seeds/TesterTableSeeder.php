<?php

use Illuminate\Database\Seeder;

class TesterTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info('--- SOLO PARA PRUEBAS ---');
        $this->command->info('--- TESTER ---');

        $gender      = Orbiagro\Models\Gender::where('description', 'Masculino')->firstOrFail();
        $parish      = Orbiagro\Models\Parish::findOrFail(1);
        $nationality = Orbiagro\Models\Nationality::where('description', 'Venezolano')->firstOrFail();
        $profile     = Orbiagro\Models\Profile::where('description', 'Administrador')->firstOrFail();

        // fix build #202
        $tester = Orbiagro\Models\User::where('name', 'tester')->firstOrFail();

        $person = new Orbiagro\Models\Person;
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
        $person->created_by     = $tester->id;
        $person->updated_by     = $tester->id;
        $tester->person()->save($person);

        $direction = new Orbiagro\Models\Direction;

        $direction->parish_id  = $parish->id;
        $direction->details    = 'Calle del tester.';
        $direction->created_by = $tester->id;
        $direction->updated_by = $tester->id;

        $tester->person->direction()->save($direction);

        $this->command->info('--- DUMMY ---');
        $profile = Orbiagro\Models\Profile::where('description', 'Usuario')->firstOrFail();

        $tester = new Orbiagro\Models\User;
        $tester->name       = 'dummy';
        $tester->email      = 'dummy@tester.com';
        $tester->password   = Hash::make('dummypw');
        $tester->profile_id = $profile->id;
        $tester->created_at = Carbon\Carbon::now();
        $tester->updated_at = Carbon\Carbon::now();
        $tester->save();

        $tester = Orbiagro\Models\User::where('name', 'dummy')->firstOrFail();

        $person = new Orbiagro\Models\Person;
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
        $person->created_by     = $tester->id;
        $person->updated_by     = $tester->id;
        $tester->person()->save($person);

        $direction = new Orbiagro\Models\Direction;

        $direction->parish_id  = $parish->id;
        $direction->details    = 'Calle del dummy.';
        $direction->created_by = $tester->id;
        $direction->updated_by = $tester->id;

        $tester->person->direction()->save($direction);

        $this->command->info('--- SOLO PARA PRUEBAS ---');
    }
}
