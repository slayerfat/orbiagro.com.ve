<?php namespace Orbiagro\Http\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\View\View as Response;
use Orbiagro\Models\Category;
use Orbiagro\Models\Product;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Orbiagro\Models\SubCategory;

/**
 * Class Carrusel
 *
 * @package Orbiagro\Http\Composers
 */
class Carrusel
{

    /**
     * @param  View $view
     * @return Response
     */
    public function composeHomeCarruselImages(View $view)
    {
        $collection = collect();

        $products = Product::latest()->take(5)->get();

        $typesId = PromoType::whereIn(
            'description',
            ['primavera', 'verano', 'otoño', 'invierno']
        )->lists('id');

        // selecciona las promociones existentes segun el tipo ya seleccionado
        $promotions = Promotion::whereIn('promo_type_id', $typesId)
            ->random()
            ->take(3)
            ->get();

        $item             = Category::random()->first();
        $item->controller = 'CategoriesController@show';

        $collection->push($item);

        $item = SubCategory::has('products')->random()->first();

        $item->controller = 'SubCategoriesController@show';

        $collection->push($item);

        $products->each(function ($product) use ($collection) {
            $product->controller = 'ProductsController@show';
            $collection->push($product);
        });

        $promotions->each(function ($promo) use ($collection) {
            $promo->controller = 'PromotionsController@show';
            $collection->push($promo);
        });

        $collection = $collection->shuffle();

        $view->with('carruselCollection', $collection);
    }
}
