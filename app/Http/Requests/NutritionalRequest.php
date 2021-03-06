<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\Nutritional;
use Orbiagro\Models\Product;

class NutritionalRequest extends Request
{

    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'methodType' => 'POST',
            'class'      => Product::class,
            'routeParam' => 'products',
        ],
        [
            'methodType' => 'PATCH',
            'class'      => Nutritional::class,
            'routeParam' => 'nutritionals',
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
        return [
            'due' => 'required|date',
        ];
    }
}
