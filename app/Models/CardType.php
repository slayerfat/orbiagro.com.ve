<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\CardType
 *
 * @property integer $id
 * @property string $description
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Billing[] $billings
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\CardType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CardType extends Model
{

    use InternalDBManagement;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}
