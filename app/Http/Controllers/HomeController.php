<?php namespace App\Http\Controllers;

use App\SubCategory;
use App\Promotion;
use App\PromoType;
use App\Mamarrachismo\VisitsService;

class HomeController extends Controller {

  /**
   * Show the application dashboard to the user.
   *
   * @return Response
   */
  public function index()
  {
    $sub_category = SubCategory::has('products')->random()->first();

    // TODO: mejorar logica de seleccion de tipos de promociones
    // TODO: abstraer a una clase o incluirlo dentro de la clase Promotion
    // selecciona los tipos especificos
    $typesId = PromoType::whereIn('description', ['primavera', 'verano', 'otoño', 'invierno'])->lists('id');
    // selecciona las promociones existentes segun el tipo ya seleccionado
    $promotions = Promotion::whereIn('promo_type_id', $typesId)->random()->take(3)->get();

    return view('home.index', compact('sub_category', 'promotions'));
  }

  public function unverified()
  {
    $user  = Auth::user();

    return view('auth.verification', compact('user'));
  }

}
