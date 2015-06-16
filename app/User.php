<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Mamarrachismo\ModelValidation;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

  use Authenticatable, CanResetPassword, SoftDeletes;

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
    if($pw = ModelValidation::byLenght($value, 6)) :
      $this->attributes['password'] = $pw;
    else:
      $this->attributes['password'] = null;
    endif;

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
    if ($this->profile->description === 'Administrador') return true;
    return false;
  }

  public function isUser()
  {
    if ($this->profile->description === 'Usuario') return true;
    return false;
  }

  public function isDisabled()
  {
    if ($this->profile->description === 'Desactivado') return true;
    return false;
  }

  public function isVerified()
  {
   if ($this->profile->description !== 'Desactivado') return true;
    return false;
  }

  /**
   * chequea si el id del foreign key del producto es igual al id del usuario
   *
   * @param int $id el foreign key del producto.
   */
  public function isOwner($id)
  {
    if ($this->attributes['id'] === $id) return true;
    return false;
  }

  /**
   * chequea si el id del foreign key del producto es igual al id del usuario
   *
   * @param int $id el foreign key del producto.
   */
  public function isOwnerOrAdmin($id)
  {
    if ($this->profile->description === 'Administrador') return true;
    return $this->isOwner($id);
  }

}
