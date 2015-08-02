<?php namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

use App\Product;

class ProductRequest extends Request {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    // si ruta es nula entonces se esta creado un nuevo recurso
    if (!$this->route('productos'))
      return Auth::user()->isVerified();

    // si ruta no es nula entonces se esta manipulando un recurso
    $producto = Product::find($this->route('productos'));
    return Auth::user()->isOwnerOrAdmin($producto->user_id);
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title'           => 'required|string|min:5',
      'description'     => 'required|string|min:20',
      'price'           => 'required|numeric',
      'quantity'        => 'required|numeric',
      'parish_id'       => 'required|numeric',
      'maker_id'        => 'required|numeric',
      'sub_category_id' => 'required|numeric',
      'latitude'        => 'numeric',
      'longitude'       => 'numeric',
      'images'          => 'array|between:1,5',
      'details'         => 'min:5',
    ];
  }

}
