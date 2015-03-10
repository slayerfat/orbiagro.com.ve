<?php

use Illuminate\Database\Seeder;

class StateTableSeeder extends Seeder {

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
      (1, 'Distrito Capital', current_timestamp, current_timestamp),
      (2, 'Anzoátegui'      , current_timestamp, current_timestamp),
      (3, 'Amazonas'        , current_timestamp, current_timestamp),
      (4, 'Apure'           , current_timestamp, current_timestamp),
      (5, 'Aragua'          , current_timestamp, current_timestamp),
      (6, 'Barinas'         , current_timestamp, current_timestamp),
      (7, 'Bolívar'         , current_timestamp, current_timestamp),
      (8, 'Carabobo'        , current_timestamp, current_timestamp),
      (9, 'Cojedes'         , current_timestamp, current_timestamp),
      (10, 'Delta Amacuro'  , current_timestamp, current_timestamp),
      (11, 'Falcón'         , current_timestamp, current_timestamp),
      (12, 'Guárico'        , current_timestamp, current_timestamp),
      (13, 'Lara'           , current_timestamp, current_timestamp),
      (14, 'Mérida'         , current_timestamp, current_timestamp),
      (15, 'Miranda'        , current_timestamp, current_timestamp),
      (16, 'Monagas'        , current_timestamp, current_timestamp),
      (17, 'Nueva Esparta'  , current_timestamp, current_timestamp),
      (18, 'Portuguesa'     , current_timestamp, current_timestamp),
      (19, 'Sucre'          , current_timestamp, current_timestamp),
      (20, 'Táchira'        , current_timestamp, current_timestamp),
      (21, 'Trujillo'       , current_timestamp, current_timestamp),
      (22, 'Yaracuy'        , current_timestamp, current_timestamp),
      (23, 'Vargas'         , current_timestamp, current_timestamp),
      (24, 'Zulia'          , current_timestamp, current_timestamp);");

    $this->command->info('Los estados de venezuela fueron creados por el elegido.');
  }

}
