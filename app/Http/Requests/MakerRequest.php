<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;

class MakerRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->isUserAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name'   => 'required|unique:makers|between:5,40',
                    'domain' => 'unique:makers|max:255',
                    'url'    => 'unique:makers|url|max:255',
                    'image'  => 'image|mimes:jpeg,jpg,png,gif,svg'
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'name'   => 'required|between:5,40|unique:makers,name,'.(int)$this->route('makers'),
                    'domain' => 'max:255|unique:makers,domain,'.(int)$this->route('makers'),
                    'url'    => 'url|max:255|unique:makers,url,'.(int)$this->route('makers'),
                    'image'  => 'image|mimes:jpeg,jpg,png,gif,svg'
                ];

            default:
                break;
        }
    }
}
