<?php namespace App\Http\Requests;

use Auth;
use App\Http\Requests\Request;

class PeopleRequest extends Request
{

    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return Auth::user()->isOwnerOrAdmin($this->route('datos-personales'));
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        // @see UserRequest
        switch ($this->method()) {
            case 'POST':
                return [
                    'identity_card'  => 'numeric|between:999999,99999999|unique:people',
                    'first_name'     => 'alpha|max:40',
                    'last_name'      => 'alpha|max:40',
                    'first_surname'  => 'alpha|max:40',
                    'last_surname'   => 'alpha|max:40',
                    'phone'          => 'max:40',
                    'birth_date'     => 'date',
                    'gender_id'      => 'numeric',
                    'nationality_id' => 'required_with:identity_card|numeric',
                ];
                
            case 'PUT':
            case 'PATCH':
                return [
                    'identity_card'  => 'numeric|between:999999,99999999|unique:people,identity_card,'.(int)$this->route('personas'),
                    'first_name'     => 'alpha|max:40',
                    'last_name'      => 'alpha|max:40',
                    'first_surname'  => 'alpha|max:40',
                    'last_surname'   => 'alpha|max:40',
                    'phone'          => 'max:40',
                    'birth_date'     => 'date',
                    'gender_id'      => 'numeric',
                    'nationality_id' => 'required_with:identity_card|numeric',
                ];

            default:
                break;
        }
    }
}
