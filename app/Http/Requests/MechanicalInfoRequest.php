<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\MechanicalInfo;

class MechanicalInfoRequest extends Request
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
        $mech = MechanicalInfo::findOrFail($this->route('mechanicals'));

        return $this->auth->user()->isOwnerOrAdmin($mech->product->user_id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lift'       => 'numeric',
            'cylinders'  => 'numeric',
            'horsepower' => 'numeric',
            'mileage'    => 'numeric',
            'traction'   => 'numeric',
        ];
    }
}
