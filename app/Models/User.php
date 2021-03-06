<?php namespace Orbiagro\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

/**
 * Orbiagro\Models\User
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Orbiagro\Models\Person $person
 * @property-read \Orbiagro\Models\UserConfirmation $confirmation
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Billing[] $billings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Visit[] $visits
 * @property-read \Orbiagro\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Product[] $purchases
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereProfileId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User admins()
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\User random()
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword, SoftDeletes, CanSearchRandomly;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @param $value
     * @return mixed|null
     */
    public function setPasswordAttribute($value)
    {
        if ($password = ModelValidation::byLenght($value, 6)) {
            return $this->attributes['password'] = $password;
        }

        return $this->attributes['password'] = null;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeAdmins($query)
    {
        $perfil = Profile::where('description', 'Administrador')->first();

        return $query->where('profile_id', $perfil->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function person()
    {
        return $this->hasOne(Person::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Illuminate\Database\Eloquent\Builder
     */
    public function confirmation()
    {
        return $this->hasOne(UserConfirmation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Eloquent\Builder
     */
    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Eloquent\Builder
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany|\Illuminate\Database\Eloquent\Builder
     */
    public function purchases()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->profile->description === 'Administrador';
    }

    /**
     * @return boolean
     */
    public function isUser()
    {
        return $this->profile->description === 'Usuario';
    }

    /**
     * @return boolean
     */
    public function isDisabled()
    {
        return $this->profile->description === 'Desactivado';
    }

    /**
     * @return boolean
     */
    public function isVerified()
    {
        return $this->profile->description !== 'Desactivado';
    }

    /**
     * @return boolean
     */
    public function hasConfirmation()
    {
        if ($this->confirmation) {
            return true;
        }

        return false;
    }

    /**
     * chequea si el id del foreign key del producto es igual al id del usuario
     *
     * @param int $id el foreign key del producto.
     * @return boolean
     */
    public function isOwner($id)
    {
        if (!isset($id)) {
            return false;
        }

        if (isset($this->attributes['id'])) {
            $userId = $this->attributes['id'];
        } elseif (isset($this->attributes['name'])) {
            $userId = $this->attributes['name'];
        }

        if (isset($userId)) {
            return $userId == $id;
        }

        return false;
    }

    /**
     * chequea si el id del foreign key del producto es igual al id del usuario
     *
     * @param int $id el foreign key del producto.
     * @return boolean
     */
    public function isOwnerOrAdmin($id)
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->isOwner($id);
    }

    /**
     * devuelve los productos eliminados relacionados con un usuario
     *
     * @param int $quantity la cantidad a tomar
     */
    public function latestDeletedProducts($quantity = 5)
    {
        return $this->products()->onlyTrashed()->latest()->take($quantity)->get();
    }

    /**
     * forceDeleting es el atributo relacionado cuando
     * algun modelo es eliminado de verdad
     * en la aplicacion.
     *
     * @return boolean
     */
    public function isForceDeleting()
    {
        return $this->forceDeleting;
    }
}
