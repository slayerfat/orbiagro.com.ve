<?php

use Illuminate\Database\Seeder;

class TesterTownTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement("INSERT INTO towns
      (id, state_id, description, created_at, updated_at)
      VALUES
      (1, 1, 'Libertador', current_timestamp, current_timestamp);");

    $this->command->info('Los municipios de venezuela fueron creados por el elegido.');
  }

}
