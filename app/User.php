<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

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

  /**
   * Relaciones
   */
  public function person()
  {
    return $this->hasOne('App\Person');
  }

  public function profile()
  {
    return $this->belongsTo('App\Profile');
  }

  /**
   * scopes y mutators
   */
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

}
