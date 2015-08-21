<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Bank;

class BankTableSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Bank! ***");

        $faker = Faker::create('es_ES');

        $bank = Bank::create([
            'description' => 'Sin Banco Asociado',
            'created_by'  => $this->user->id,
            'updated_by'  => $this->user->id,
        ]);

        $this->command->info("{$bank->description} creado.");

        foreach (range(1, 2) as $index) {
            $bank = Bank::create([
                'description' => 'Banco '.$faker->company(),
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);
            $this->command->info("{$bank->description} creado.");
        }

        $this->command->info('Creacion de bancos completo.');
    }
}
