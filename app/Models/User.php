<?php namespace Orbiagro\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

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
        return $this->hasOne('App\Person');
    }

    public function confirmation()
    {
        return $this->hasOne('App\UserConfirmation');
    }

    // --------------------------------------------------------------------------
    // Has Many
    // --------------------------------------------------------------------------
    public function billings()
    {
        return $this->hasMany('App\Billing');
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------
    public function purchases()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity')->withTimestamps();
    }

    // --------------------------------------------------------------------------
    // Funciones Publicas
    // --------------------------------------------------------------------------
    public function isAdmin()
    {
        return $this->profile->description === 'Administrador';
    }

    public function isUser()
    {
        return $this->profile->description === 'Usuario';
    }

    public function isDisabled()
    {
        return $this->profile->description === 'Desactivado';
    }

    public function isVerified()
    {
        return $this->profile->description !== 'Desactivado';
    }

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
     */
    public function isOwner($id)
    {
        if (!isset($this->attributes['id'])) {
            $this->attributes['id'] = null;
        }

        if (!isset($this->attributes['name'])) {
            $this->attributes['name'] = null;
        }

        if ($this->attributes['id'] === $id ||
        $this->attributes['name'] === $id) {
            return true;
        }

        return false;
    }

    /**
     * chequea si el id del foreign key del producto es igual al id del usuario
     *
     * @param int $id el foreign key del producto.
     */
    public function isOwnerOrAdmin($id)
    {
        if ($this->profile->description === 'Administrador') {
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
