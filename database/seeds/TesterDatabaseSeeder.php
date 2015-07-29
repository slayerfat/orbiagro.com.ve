<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TesterDatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $this->command->info("*** Empezando Migracion de TESTER! ***");

    $this->call('GenderTableSeeder');
    $this->call('NationalityTableSeeder');
    $this->call('TesterStateTableSeeder');
    $this->call('TesterTownTableSeeder');
    $this->call('TesterParishTableSeeder');
    $this->call('TesterTableSeeder');
    $this->call('CategoryTableSeeder');
    $this->call('SubCategoryTableSeeder');
    $this->call('TesterMakerTableSeed');
    $this->call('TesterProductTableSeeder');
    $this->call('TesterFeatureTableSeeder');
    $this->call('CharacteristicTableSeeder');
    $this->call('NutritionalTableSeeder');
    $this->call('MechanicalInfoTableSeeder');
    $this->call('BankTableSeeder');
    $this->call('CardTypeTableSeeder');
    $this->call('TesterBillingTableSeeder');
    $this->call('PurchaseTableSeeder');
    $this->call('VisitTableSeeder');
    $this->call('TesterImagesTableSeeder');
    $this->call('PromoTypesTableSeeder');
    $this->call('PromotionTableSeeder');
    $this->call('CategoryImageTableSeeder');
    $this->call('SubCategoryImageTableSeeder');

    $this->command->info("*** Migracion terminada de TESTER! ***");
  }

}
