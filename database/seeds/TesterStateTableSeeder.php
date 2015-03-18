<?php

use Illuminate\Database\Seeder;

class TesterStateTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement("INSERT INTO states
      (id, description, created_at, updated_at)
      VALUES
      (1, 'Distrito Capital', current_timestamp, current_timestamp);");

    $this->command->info('Los estados de venezuela fueron creados por el elegido.');
  }

}