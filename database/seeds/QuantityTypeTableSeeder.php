<?php

use Illuminate\Database\Seeder;
use Orbiagro\Models\QuantityType;

class QuantityTypeTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("*** Empezando creacion de QuantityType! ***");

        $types = [
            'Unidad',
            'Gramo',
            'Kilo',
            'Tonelada',
            'Paquete',
            'Guacal',
            'Sobre',
            'Lata',
        ];

        foreach ($types as $type) {
            QuantityType::create(['desc' => $type]);
        }

        $this->command->info('Creacion de QuantityType completado.');
    }
}
