<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Orbiagro\Models\QuantityTypeRepository
 *
 * @property integer $id
 * @property string $desc
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\QuantityType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\QuantityType whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\QuantityType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\QuantityType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class QuantityType extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['desc'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
