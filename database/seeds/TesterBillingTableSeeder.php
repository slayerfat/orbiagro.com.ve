<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Bank;
use App\CardType;
use App\Billing;

class TesterBillingTableSeeder extends Seeder {

  public function run()
  {
    $this->command->info("*** Empezando creacion de TESTER: Billing! ***");

    $faker = Faker::create('es_ES');
    $users = User::all();

    foreach($users as $user):
      $bank = Bank::where('description', 'Sin Banco Asociado')->first();
      $card = CardType::where('description', 'Sin Tarjeta Asociada')->first();
      Billing::create([
        'user_id'      => $user->id,
        'bank_id'      => $bank->id,
        'card_type_id' => $card->id,
        'card_number'  => $faker->creditCardNumber(),
        'bank_account' => $faker->bankAccountNumber(),
        'expiration'   => $faker->creditCardExpirationDateString(),
        'comments'     => $faker->text(),
        'created_by'   => $user->id,
        'updated_by'   => $user->id,
      ]);
    endforeach;
    $this->command->info('Creacion de billing completada.');
  }

}
