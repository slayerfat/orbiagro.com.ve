<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Promotion;
use Carbon\Carbon;

class PromotionTableSeeder extends Seeder {

  public function run()
  {
    $product   = Product::first();
    $promotion = Promotion::create([
      'title'      => 'Lleva 2, paga 3!',
      'slug'       => str_slug('Lleva 2, paga 3!'),
      'percentage' => 10,
      'static'     => 100,
      'begins'     => Carbon::now()->subYears(4)->toDateString(),
      'ends'       => Carbon::now()->addYears(1)->toDateString(),
    ]);

    // se empieza creado el directorio relacionado con la promo
    // primero se elimina si existe
    Storage::disk('public')->deleteDirectory("promos");

    // se crea el directorio
    Storage::disk('public')->makeDirectory("promos/{$promotion->id}");

    // el nombre del archivo
    $name = date('Ymdhmmss-').str_random(20);
    // se copia el archivo
    Storage::disk('public')->copy('1500x1500.gif', "promos/{$promotion->id}/{$name}.gif");
    $this->command->info("Creado promos/{$promotion->id}/{$name}.gif");

    $product->promotions()->attach($promotion);
  }

}
