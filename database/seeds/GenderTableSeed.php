<?php

class GenderTableSeeder extends BaseSeeder
{

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

        foreach ($types as $gender) {
            Orbiagro\Models\Gender::create([
                'description' => $gender,
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);
        }

        $this->command->info('Generos creados.');
    }
}
