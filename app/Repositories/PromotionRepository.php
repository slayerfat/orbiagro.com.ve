<?php namespace Orbiagro\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository extends AbstractRepository implements PromotionRepositoryInterface
{
    /**
     * @var \Orbiagro\Models\PromoType
     */
    protected $promoType;

    /**
     * @param PromoType $promoType
     * @param Promotion $model
     */
    public function __construct(PromoType $promoType, Promotion $model)
    {
        $this->promoType = $promoType;

        /** @var Model $model */
        parent::__construct($model);
    }

    /**
     * @return Collection
     */
    public function getHomeRelated()
    {
        // selecciona los tipos especificos
        $typesId = $this->promoType->whereIn(
            'description',
            ['primavera', 'verano', 'otoño', 'invierno']
        )->pluck('id');

        // selecciona las promociones existentes segun el tipo ya seleccionado
        $promotions = $this->model->whereIn('promo_type_id', $typesId)
            ->random()
            ->take(3)
            ->get();

        return $promotions;
    }
}
