<?php namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class ProviderRequest extends Request {

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return Auth::user()->isAdmin();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    switch($this->method())
    {
      case 'POST':
        return [
          'name'            => 'required|unique:providers',
          'url'             => 'url|max:255',
          'contact_name'    => 'string|max:255',
          'contact_title'   => 'alpha|max:10',
          'contact_email'   => 'email',
          'email'           => 'email',
          'contact_phone_1' => 'numeric',
          'contact_phone_2' => 'numeric',
          'contact_phone_3' => 'numeric',
          'contact_phone_4' => 'numeric',
          'phone_1'         => 'numeric',
          'phone_2'         => 'numeric',
          'phone_3'         => 'numeric',
          'phone_4'         => 'numeric',
          'trust'           => 'numeric',
        ];
      case 'PUT':
      case 'PATCH':
        return [
          'name'            => 'required|unique:providers,name,'.(int)$this->route('proveedores'),
          'url'             => 'url|unique:providers,url,'.(int)$this->route('proveedores'),
          'contact_name'    => 'string|max:255',
          'contact_title'   => 'alpha|max:10',
          'contact_email'   => 'email',
          'email'           => 'email',
          'contact_phone_1' => 'numeric',
          'contact_phone_2' => 'numeric',
          'contact_phone_3' => 'numeric',
          'contact_phone_4' => 'numeric',
          'phone_1'         => 'numeric',
          'phone_2'         => 'numeric',
          'phone_3'         => 'numeric',
          'phone_4'         => 'numeric',
          'trust'           => 'numeric',
        ];
      default:break;
    }
  }

}