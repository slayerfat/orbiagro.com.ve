<?php namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

use App\Product;

class NutritionalRequest extends Request {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    $producto = Product::find($this->route('mechanicals'));
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
      'due' => 'required|date'
    ];
  }

}
