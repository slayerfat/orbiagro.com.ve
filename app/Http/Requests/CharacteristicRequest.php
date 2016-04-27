<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\Characteristic;
use Orbiagro\Models\Product;

/**
 * Class CharacteristicRequest
 *
 * @package Orbiagro\Http\Requests
 */
class CharacteristicRequest extends Request
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
            'class'      => Characteristic::class,
            'routeParam' => 'characteristics',
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
            'height' => 'numeric',
            'heidth' => 'numeric',
            'depth'  => 'numeric',
            'units'  => 'numeric',
        ];
    }
}
