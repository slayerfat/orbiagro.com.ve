<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Nutritional;

class NutritionalRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        // si ruta es nula entonces se esta creado un nuevo recurso
        if (!$this->route('mechanicals')) {
            return $this->auth->user()->isVerified();
        }

        // si ruta no es nula entonces se esta manipulando un recurso
        $nuts = Nutritional::findOrFail($this->route('mechanicals'));

        return $this->auth->user()->isOwnerOrAdmin($nuts->product->user_id);
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
