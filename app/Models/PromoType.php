<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\PromoType
 *
 * @property integer $id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Promotion[] $promotions
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\PromoType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PromoType extends Model
{

    use InternalDBManagement;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }
}
