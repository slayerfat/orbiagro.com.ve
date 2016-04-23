<?php namespace Orbiagro\Http\Requests;

use Orbiagro\Mamarrachismo\Traits\Requests\CanSearchIDs;
use Orbiagro\Models\Product;

class ProductRequest extends Request
{

    use CanSearchIDs;

    /**
     * @var array
     */
    protected $resourcesData = [
        [
            'methodType' => 'PATCH',
            'class'      => Product::class,
            'routeParam' => 'products'
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
            'title'           => 'required|string|min:5',
            'description'     => 'required|string|min:20',
            'price'           => 'numeric|between:1,9999999999',
            'quantity'        => 'required|numeric',
            'parish_id'       => 'required|numeric',
            'maker_id'        => 'required|numeric',
            'sub_category_id' => 'required|numeric',
            'latitude'        => 'numeric',
            'longitude'       => 'numeric',
            'images'          => 'array|between:1,5',
            'details'         => 'min:5',
        ];
    }
}
