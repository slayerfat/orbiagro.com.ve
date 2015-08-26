<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Http\Requests\Request;
use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\MechanicalInfo;
use Orbiagro\Models\Product;

/**
 * Class MechanicalInfoRequest
 * @package Orbiagro\Http\Requests
 */
class MechanicalInfoRequest extends Request
{
    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'methodType' => 'POST',
            'class'      => Product::class,
            'routeParam' => 'products'
        ],
        [
            'methodType' => 'PATCH',
            'class'      => MechanicalInfo::class,
            'routeParam' => 'mechanicals'
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
            'lift'       => 'numeric',
            'cylinders'  => 'numeric',
            'horsepower' => 'numeric',
            'mileage'    => 'numeric',
            'traction'   => 'numeric',
        ];
    }
}
