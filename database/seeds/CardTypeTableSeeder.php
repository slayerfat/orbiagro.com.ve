<?php

use Illuminate\Database\Seeder;

use App\CardType;
use App\User;

class CardTypeTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de CardType! ***");

    $user = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

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
        'created_by'  => $user->id,
        'updated_by'  => $user->id,
      ]);
    endforeach;
    $this->command->info('Creacion de tipos de tarjetas de credito completada.');
  }

}
