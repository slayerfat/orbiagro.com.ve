<?php

use Illuminate\Database\Seeder;

class PromoTypesTableSeeder extends BaseSeeder
{

    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $this->command->info("*** Empezando creacion de PromoType! ***");

        $types = [
            'otro',
            '1:1 300x300',
            '4:1 1200x300',
            '4:3 640x480',
            '12:5 1200x500',
            '13:5 1300x500',
            '16:9 1280x720',
            'verano',
            'otoño',
            'invierno',
            'primavera',
        ];

        foreach ($types as $type) {
            $type = App\PromoType::create([
                'description' => $type,
                'created_by'  => $this->user->id,
                'updated_by'  => $this->user->id,
            ]);

            $this->command->info("promotion type: {$type->description}.");
        }

        $this->command->info('tipos de promociones completa.');
    }
}
