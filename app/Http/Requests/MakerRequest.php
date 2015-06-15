<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class MakerRequest extends Request {

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
      'name' => 'required|unique:makers|between:5,40',
      'domain' => 'unique:makers|max:255',
      'url' => 'unique:makers|url|max:255',
      'image' => 'image'
    ];
  }

}
