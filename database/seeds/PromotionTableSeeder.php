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
    $product->promotions()->attach($promotion);
  }

}
