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
    $this->call('StateTableSeeder');
    $this->call('TownTableSeeder');
    $this->call('ParishTableSeeder');
    $this->call('TesterTableSeeder');
    $this->call('CategoryTableSeeder');
    $this->call('SubCategoryTableSeeder');
    $this->call('MakerTableSeeder');
    $this->call('TesterProductTableSeeder');
    $this->call('TesterFeatureTableSeeder');
  }

}
