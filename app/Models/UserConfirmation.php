<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Orbiagro\Models\UserConfirmation
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $data
 * @property-read \Orbiagro\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\UserConfirmation whereData($value)
 * @mixin \Eloquent
 */
class UserConfirmation extends Model
{

    /**
     * La tabla no posee timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'data',
    ];

    /**
     * @return void
     */
    public function setDataAttribute()
    {
        $this->attributes['data'] = str_random(32);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
