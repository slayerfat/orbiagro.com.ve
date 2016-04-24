<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\Person;

class PeopleRequest extends Request
{

    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'class'      => Person::class,
            'routeParam' => 'users',
        ],
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isUserAdmin()) {
            return true;
        }

        return $this->isUserOwner($this->resourcesData);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        /**
         * @see UserRequest
         */
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
                    'identity_card'  => 'numeric|between:999999,99999999|unique:people,identity_card,'
                        . (int)$this->route('people'),
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
                return [];
        }
    }
}
