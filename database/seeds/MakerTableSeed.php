<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\User;
use App\Image;

class MakerTableSeeder extends Seeder {

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->command->info("*** Empezando creacion de Maker! ***");

    $faker = Faker::create('es_ES');
    $user   = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

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

        // se empieza creado el directorio relacionado con el producto
        // primero se elimina si existe
        Storage::disk('public')->deleteDirectory("makers/{$maker->id}");
        Storage::disk('public')->makeDirectory("makers/{$maker->id}");

        // el nombre del archivo
        $name = date('Ymdhmmss-').str_random(20);
        // se copia el archivo
        Storage::disk('public')->copy('1500x1500.gif', "makers/{$maker->id}/{$name}.gif");
        $this->command->info("Creado makers/{$maker->id}/{$name}.gif");

        // el modelo
        $image             = new Image;
        $image->path       = "makers/{$maker->id}/{$name}.gif";
        $image->mime       = 'image/gif';
        $image->alt        = $maker->slug;
        $image->created_by = $user->id;
        $image->updated_by = $user->id;
        $maker->image()->save($image);
      endfor;
    endforeach;
    $this->command->info('Creacion de compañias completa.');
  }

}
