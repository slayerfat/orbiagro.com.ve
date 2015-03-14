<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MakerTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Faker::create('es_ES');

    $subcat = App\SubCategory::all();
    foreach($subcat as $subcategory):
      for ($i=0; $i < 2; $i++) :
        $company = $faker->company();
        $maker = App\Maker::create([
          'name'   => $company,
          'slug'   => str_slug($company),
          'domain' => $faker->domainName(),
          'url'    => $faker->url(),
        ]);
        $maker->sub_categories()->attach($subcategory->id);
      endfor;
    endforeach;
    $this->command->info('Creacion de compañias completa.');
  }

}
