<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

  /**
   * usado para subir imagenes o archivos
   * relacionados con algun modelo.
   */
  protected $upload;

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    // Telling Eloquent to allow mass assignment.
    Model::unguard();

    $this->command->info("*** Empezando Migracion! ***");

    // tablas secundarias
    $this->call(GenderTableSeeder::class);
    $this->call(NationalityTableSeeder::class);
    $this->call(StateTableSeeder::class);
    $this->call(TownTableSeeder::class);
    $this->call(ParishTableSeeder::class);
    $this->call(PeopleTableSeeder::class);
    $this->call(CategoryTableSeeder::class);
    $this->call(SubCategoryTableSeeder::class);
    $this->call(MakerTableSeeder::class);
    $this->call(BankTableSeeder::class);
    $this->call(CardTypeTableSeeder::class);
    $this->call(PromoTypesTableSeeder::class);

    // tablas primarias
    $this->call(ProviderTableSeed::class);
    $this->call(ProductTableSeeder::class);
    $this->call(BillingTableSeeder::class);
    $this->call(PurchaseTableSeeder::class);
    $this->call(VisitTableSeeder::class);
    $this->call(ProductProviderTableSeed::class);
    $this->call(PromotionTableSeeder::class);

    $this->command->info("*** Migracion terminada! ***");

    // Telling Eloquent to not allow mass assignment.
    Model::reguard();
  }

}
