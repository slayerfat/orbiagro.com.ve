<?php

use Illuminate\Database\Seeder;

class TesterTownTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de TESTER: Town! ***");
        DB::statement("INSERT INTO towns
            (id, state_id, description, created_at, updated_at, created_by, updated_by)
            VALUES
            (1, 1, 'Libertador', current_timestamp, current_timestamp, 1, 1);");

        $this->command->info('Los municipios de venezuela fueron creados por el elegido.');
    }
}
