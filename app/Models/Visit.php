<?php namespace Orbiagro\Models;

use Orbiagro\Models\User;
use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Visit
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $visitable_id
 * @property string $visitable_type
 * @property integer $total
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Orbiagro\Models\User $user
 * @property-read \ $visitable
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereVisitableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereVisitableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereTotal($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Visit whereUpdatedAt($value)
 */
class Visit extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs to
    // --------------------------------------------------------------------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --------------------------------------------------------------------------
    // Polymorphic
    // --------------------------------------------------------------------------
    public function visitable()
    {
        return $this->morphTo();
    }
}
