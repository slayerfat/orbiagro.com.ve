<?php

use Illuminate\Database\Seeder;

class BillingTableSeeder extends Seeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de Billing! ***");

        factory(Orbiagro\Models\Billing::class, 2)->make()->each(function ($bill) {
            Orbiagro\Models\User::first()->billings()->save($bill);
        });

        $this->command->info('Creacion de billing completada.');
    }
}
