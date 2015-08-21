<?php

use Illuminate\Database\Seeder;

class TesterStateTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de TESTER: State! ***");
        DB::statement("INSERT INTO states
            (id, description, created_at, updated_at, created_by, updated_by)
            VALUES
            (1, 'Distrito Capital', current_timestamp, current_timestamp, 1, 1);");

        $this->command->info('Los estados de venezuela fueron creados por el elegido.');
    }
}
