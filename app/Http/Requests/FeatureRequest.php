<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Models\Feature;
use Orbiagro\Models\Product;
use Orbiagro\Http\Requests\Request;
use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;

/**
 * Class FeatureRequest
 * @package Orbiagro\Http\Requests
 */
class FeatureRequest extends Request
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
            'class'      => Feature::class,
            'routeParam' => 'features'
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
            'title'           => 'required|string|between:5,40',
            'description'     => 'required|string|min:10',
            'images'          => 'image ',
        ];
    }
}
