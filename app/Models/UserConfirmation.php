<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Orbiagro\Models\UserConfirmation
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $data
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereData($value)
 */
class UserConfirmation extends Model
{

    /**
     * La tabla no posee timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $fillable = [
        'data'
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDataAttribute()
    {
        $this->attributes['data'] = str_random(32);
    }

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
}
