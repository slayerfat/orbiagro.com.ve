<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;
use Orbiagro\Models\Feature;

class FeatureRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // si ruta es nula entonces se esta creado un nuevo recurso
        if (!$this->route('productos')) {
            return $this->auth->user()->isVerified();
        }

        // si ruta no es nula entonces se esta manipulando un recurso
        $feature = Feature::findOrFail($this->route('productos'));

        return $this->auth->user()->isOwnerOrAdmin($feature->product->user_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'           => 'required|string|between:5,40',
            'description'     => 'required|string|min:10',
            'images'          => 'image',
        ];
    }
}
