<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubCategoryRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->auth->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|min:3',
            'info'        => 'required|min:5',
            'category_id' => 'required|numeric',
            'image'       => 'image',
        ];
    }
}
