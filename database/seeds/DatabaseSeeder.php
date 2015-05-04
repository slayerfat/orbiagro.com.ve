<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    $this->call('ProfileTableSeeder');
    $this->call('GenderTableSeeder');
    $this->call('NationalityTableSeeder');
    $this->call('StateTableSeeder');
    $this->call('TownTableSeeder');
    $this->call('ParishTableSeeder');
    $this->call('NeoTableSeeder');
    $this->call('CategoryTableSeeder');
    $this->call('SubCategoryTableSeeder');
    $this->call('MakerTableSeeder');
    $this->call('ProductTableSeeder');
    $this->call('FeatureTableSeeder');
    $this->call('CharacteristicTableSeeder');
    $this->call('NutritionalTableSeeder');
    $this->call('MechanicalInfoTableSeeder');
    $this->call('BankTableSeeder');
    $this->call('CardTypeTableSeeder');
    $this->call('BillingTableSeeder');
    $this->call('PurchaseTableSeeder');
    $this->call('VisitTableSeeder');
    $this->call('ImagesTableSeeder');
    $this->call('PromotionTableSeeder');
    $this->call('CategoryImageTableSeeder');
    $this->call('SubCategoryImageTableSeeder');
  }

}
