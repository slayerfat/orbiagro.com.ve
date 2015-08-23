<?php namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use App\Promotion;
use App\PromoType;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class HomeController extends Controller
{

    use SEOToolsTrait;

    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
    * Show the application index to the user.
    *
    * @todo mejorar logica de seleccion de tipos de promociones,
    * 		abstraer a una clase o incluirlo dentro de la clase Promotion
    *
    * @return Response
    */
    public function index()
    {
        $subCategory = SubCategory::has('products')->random()->first();

        $cats = Category::all();

        // selecciona los tipos especificos
        $typesId = PromoType::whereIn('description', ['primavera', 'verano', 'otoño', 'invierno'])->lists('id');

        // selecciona las promociones existentes segun el tipo ya seleccionado
        $promotions = Promotion::whereIn('promo_type_id', $typesId)->random()->take(3)->get();

        $this->seo()->opengraph()->setUrl(action('HomeController@index'));

        return view('home.index', compact('subCategory', 'promotions', 'cats'));
    }

    /**
     * Muestra la vista para el usuario no verificado.
     *
     * @return Response
     */
    public function unverified()
    {
        $user  = \Auth::user();

        return view('auth.verification', compact('user'));
    }
}
