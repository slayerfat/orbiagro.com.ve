<?php

use Illuminate\Database\Seeder;

use Orbiagro\Models\CardType;

class CardTypeTableSeeder extends BaseSeeder
{

    public function run()
    {
        $this->command->info("*** Empezando creacion de CardType! ***");

        $data  = [
            'Visa',
            'MasterCard',
            'American Express',
            'Discover Card',
            'Debito',
            'Sin Tarjeta Asociada'
        ];

        foreach ($data as $value) {
            CardType::create([
                'description' => $value,
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);
        }

        $this->command->info('Creacion de tipos de tarjetas de credito completada.');
    }
}
