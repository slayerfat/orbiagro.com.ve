<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Product;
use App\Image;
use App\Promotion;
use App\PromoType;
use Carbon\Carbon;

class PromotionTableSeeder extends Seeder {

  public function run()
  {
    $user  = User::where('name', 'tester')->first();

    if(!$user) $user = User::where('name', env('APP_USER'))->first();

    $product   = Product::first();
    $promoType = PromoType::where('description', 'primavera')->first();
    $promotion = Promotion::create([
      'title'         => 'Lleva 2, paga 3!',
      'slug'          => str_slug('Lleva 2, paga 3!'),
      'promo_type_id' => $promoType->id,
      'percentage'    => 10,
      'static'        => 100,
      'begins'        => Carbon::now()->subYears(4)->toDateString(),
      'ends'          => Carbon::now()->addYears(1)->toDateString(),
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

    // el modelo
    $image             = new Image;
    $image->path       = "promos/{$promotion->id}/{$name}.gif";
    $image->mime       = 'image/gif';
    $image->alt        = $promotion->title;
    $image->created_by = $user->id;
    $image->updated_by = $user->id;
    $promotion->images()->save($image);

    $product->promotions()->attach($promotion);
  }

}
