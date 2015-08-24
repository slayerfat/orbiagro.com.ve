<?php

use Illuminate\Database\Seeder;

use Orbiagro\Models\User;

class NationalityTableSeeder extends BaseSeeder
{

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

        foreach ($types as $type) {
            App\Nationality::create([
                'description' => $type,
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);
        }

        $this->command->info('El Elegido necesita una Nacionalidad...');
    }
}
