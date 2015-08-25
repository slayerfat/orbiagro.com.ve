<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;
use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;

class CharacteristicRequest extends Request
{

    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'methodType' => 'POST',
            'class'      => \Orbiagro\Models\Product::class,
            'routeParam' => 'products'
        ],
        [
            'methodType' => 'PATCH',
            'class'      => \Orbiagro\Models\Characteristic::class,
            'routeParam' => 'characteristics'
        ]
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
            'height' => 'numeric',
            'heidth' => 'numeric',
            'depth'  => 'numeric',
            'units'  => 'numeric',
        ];
    }
}
