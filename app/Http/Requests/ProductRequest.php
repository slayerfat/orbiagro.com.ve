<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'title'           => 'required|string',
      'description'     => 'required|string',
      'price'           => 'required|numeric',
      'quantity'        => 'required|numeric',
      'parish_id'       => 'required|numeric',
      'maker_id'        => 'required|numeric',
      'sub_category_id' => 'required|numeric',
      'latitude'        => 'numeric',
      'longitude'       => 'numeric',
      'images'          => 'required|array|between:1,5',
    ];
  }

}
