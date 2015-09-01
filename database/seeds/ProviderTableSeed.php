<?php

use Illuminate\Database\Seeder;

class ProviderTableSeed extends Seeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de Provider! ***");

        factory(Orbiagro\Models\Provider::class, 3)->create();

        $this->command->info('providers completados.');
    }
}
