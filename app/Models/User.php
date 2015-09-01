<?php namespace Orbiagro\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

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
 * @property-read Person $person
 * @property-read UserConfirmation $confirmation
 * @property-read \Illuminate\Database\Eloquent\Collection|Billing[] $billings
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|Visit[] $visits
 * @property-read Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $purchases
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
 * @method static \Illuminate\Database\Eloquent\Builder|\Orbiagro\Models\User findOrFail($id, $columns = [])
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

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setPasswordAttribute($value)
    {
        if ($password = ModelValidation::byLenght($value, 6)) {
            return $this->attributes['password'] = $password;
        }

        return $this->attributes['password'] = null;
    }

    // --------------------------------------------------------------------------
    // Scopes
    // --------------------------------------------------------------------------
    public function scopeAdmins($query)
    {
        $perfil = Profile::where('description', 'Administrador')->first();

        return $query->where('profile_id', $perfil->id);
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Has one
    // --------------------------------------------------------------------------
    public function person()
    {
        return $this->hasOne(Person::class);
    }

    public function confirmation()
    {
        return $this->hasOne(UserConfirmation::class);
    }

    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------
    public function purchases()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }

    // --------------------------------------------------------------------------
    // Funciones Publicas
    // --------------------------------------------------------------------------
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
     *
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
     *
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
