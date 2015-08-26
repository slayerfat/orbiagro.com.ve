<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;
use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\User;

/**
 * Class UserRequest
 * @package Orbiagro\Http\Requests
 */
class UserRequest extends Request
{

    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'methodType' => 'PATCH',
            'class'      => User::class,
            'routeParam' => 'users'
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
        // si es para crear (post) es standard.
        // si es para actualizar (patch, put) el unique pasa ignorando el id
        switch ($this->method()) {
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
                    'name'       => 'required|max:255|unique:users,name,'.(int)$this->route('users'),
                    'email'      => 'required|email|max:255|unique:users,email,'.(int)$this->route('users'),
                    'password'   => 'confirmed|min:6',
                    'profile_id' => 'required|numeric',
                ];

            default:
                return [];
        }
    }
}
