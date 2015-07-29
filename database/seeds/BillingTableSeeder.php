<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\User;
use App\Bank;
use App\CardType;
use App\Billing;

class BillingTableSeeder extends Seeder {

  public function run()
  {
    $faker = Faker::create('es_ES');
    $users = User::all();

    $this->command->info("*** Empezando creacion de Billing! ***");

    $admin = User::where('name', 'tester')->first();

    if(!$admin) $admin = User::where('name', env('APP_USER'))->first();

    foreach($users as $user):
      $this->command->info("Dentro del bucle {$user->name}");
      $bank = Bank::orderByRaw('rand()')->first();
      $card = CardType::orderByRaw('rand()')->first();
      Billing::create([
        'user_id'      => $user->id,
        'bank_id'      => $bank->id,
        'card_type_id' => $card->id,
        'card_number'  => $faker->creditCardNumber(),
        'bank_account' => $faker->bankAccountNumber(),
        'expiration'   => $faker->creditCardExpirationDateString(),
        'comments'     => $faker->text(),
        'created_by'   => $admin->id,
        'updated_by'   => $admin->id,
      ]);
    endforeach;
    $this->command->info('Creacion de billing completada.');
  }

}
