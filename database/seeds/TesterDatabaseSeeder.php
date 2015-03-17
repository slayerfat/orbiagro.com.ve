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

    $this->call('ProfileTableSeeder');
    $this->call('GenderTableSeeder');
    $this->call('NationalityTableSeeder');
    $this->call('TesterStateTableSeeder');
    $this->call('TesterTownTableSeeder');
    $this->call('TesterParishTableSeeder');
    $this->call('TesterTableSeeder');
    $this->call('CategoryTableSeeder');
    $this->call('SubCategoryTableSeeder');
    $this->call('MakerTableSeeder');
    $this->call('TesterProductTableSeeder');
    $this->call('TesterFeatureTableSeeder');
    $this->call('CharacteristicTableSeeder');
    $this->call('NutritionalTableSeeder');
    $this->call('MechanicalInfoTableSeeder');
  }

}
