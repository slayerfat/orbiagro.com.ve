<?php

namespace Orbiagro\Http\Requests;

class QuantityTypeRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                return [
                    'desc' => 'required|string|unique:quantity_types,desc,'
                        . (int)$this->route('quantityTypes'),
                ];
            default:
                return [
                    'desc' => 'required|string|unique:quantity_types',
                ];
        }
    }
}
