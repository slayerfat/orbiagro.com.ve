<?php namespace Orbiagro\Repositories;

use Orbiagro\Models\Promotion;
use Orbiagro\Models\PromoType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Orbiagro\Repositories\Interfaces\PromotionRepositoryInterface;

class PromotionRepository extends AbstractRepository implements PromotionRepositoryInterface
{
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
        )->lists('id');

        // selecciona las promociones existentes segun el tipo ya seleccionado
        $promotions = $this->model->whereIn('promo_type_id', $typesId)
            ->random()
            ->take(3)
            ->get();

        return $promotions;
    }
}
