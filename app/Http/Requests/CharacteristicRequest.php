<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;
use Orbiagro\Models\Characteristic;

class CharacteristicRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // si ruta es nula entonces se esta creado un nuevo recurso
        if (!$this->route('mechanicals')) {
            return $this->auth->user()->isVerified();
        }

        // si ruta no es nula entonces se esta manipulando un recurso
        $char = Characteristic::findOrFail($this->route('mechanicals'));

        return $this->auth->user()->isOwnerOrAdmin($char->product->user_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
