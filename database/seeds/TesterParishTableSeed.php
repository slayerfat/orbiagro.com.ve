<?php

use Illuminate\Database\Seeder;

class TesterParishTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::statement("INSERT INTO parishes
      (town_id, description, created_at, updated_at)
      VALUES
      (1, 'Altagracia', current_timestamp, current_timestamp);");
    $this->command->info('Las parroquias de venezuela fueron creadas por el elegido.');
  }

}
