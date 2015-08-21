<?php

use Illuminate\Database\Seeder;

class TesterParishTableSeeder extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de TESTER: Parish! ***");

        DB::statement("INSERT INTO parishes
            (town_id, description, created_at, updated_at, created_by, updated_by)
            VALUES
            (1, 'Altagracia', current_timestamp, current_timestamp, 1, 1);");

        $this->command->info('Las parroquias de venezuela fueron creadas por el elegido.');
    }

}
