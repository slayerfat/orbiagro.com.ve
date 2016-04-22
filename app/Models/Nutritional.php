<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Nutritional
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $due
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \Orbiagro\Models\Product $product
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereDue($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Nutritional whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Nutritional extends Model
{

    use InternalDBManagement;

    protected $fillable = ['due'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDueAttribute($value)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);

        if ($date) {
            return $this->attributes['due'] = $value;
        }

        return $this->attributes['due'] = null;
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
