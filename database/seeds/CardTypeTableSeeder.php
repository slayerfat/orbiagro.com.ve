<?php

use Illuminate\Database\Seeder;
use App\CardType;

class CardTypeTableSeeder extends Seeder {

  public function run()
  {
    $data  = [
      'Visa',
      'MasterCard',
      'American Express',
      'Discover Card',
      'Debito',
      'Sin Tarjeta Asociada'
    ];

    foreach($data as $value):
      CardType::create([
        'description' => $value,
      ]);
    endforeach;
    $this->command->info('Creacion de tipos de tarjetas de credito completada.');
  }

}
