<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;

/**
 * Orbiagro\Models\Profile
 *
 * @property integer $id
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Profile whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Profile whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['description'];

    /**
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ModelValidation::byLenght($value);
    }

    /**
     * @param $value
     * @return null|string
     */
    public function getDescriptionAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
