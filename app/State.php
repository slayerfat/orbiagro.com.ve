<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;

class State extends Model
{

    use InternalDBManagement;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------
    public function towns()
    {
        return $this->hasMany('App\Towns');
    }
}
