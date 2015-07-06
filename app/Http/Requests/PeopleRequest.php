<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PeopleRequest extends Request {

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
    // @see UserRequest
    switch($this->method())
    {
      case 'POST':
        return [
          'name'       => 'required|max:255|unique:users',
          'email'      => 'required|email|max:255|unique:users',
          'password'   => 'required|confirmed|min:6',
          'profile_id' => 'required|numeric',
        ];
      case 'PUT':
      case 'PATCH':
        return [
          'identity_card' => 'required|max:11|unique:people,identity_card,'.(int)$this->route('usuarios'),
          'first_name'      => 'alpha|max:40',
          'last_name'      => 'alpha|max:40',
          'first_surname'      => 'alpha|max:40',
          'last_surname'      => 'alpha|max:40',
          'phone' => 'numeric',
          'birth_date' => 'numeric',
          'gender_id' => 'numeric',
          'nationality_id' => 'required_with:identity_card|numeric',
        ];
      default:break;
    }
  }

}
