<?php namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

use App\Product;
use App\Category;
use App\PromoType;
use App\Promotion;
use App\SubCategory;

class Carrusel {

  public function composeHomeCarruselImages(View $view)
  {
    $collection = collect();

    $products = Product::latest()->take(5)->get();

    $typesId = PromoType::whereIn('description', ['primavera', 'verano', 'otoño', 'invierno'])->lists('id');
    // selecciona las promociones existentes segun el tipo ya seleccionado
    $promotions = Promotion::whereIn('promo_type_id', $typesId)->random()->take(3)->get();

    $item = Category::random()->first();

    $collection->push($item);

    $item = SubCategory::has('products')->random()->first();

    $collection->push($item);

    $products->each(function($product) use($collection){
      $collection->push($product);
    });

    $promotions->each(function($promo) use($collection){
      $collection->push($promo);
    });

    $collection = $collection->shuffle();

    $view->with('carruselCollection', $collection);
  }
}
