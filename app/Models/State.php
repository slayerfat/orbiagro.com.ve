<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

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
        return $this->hasMany('Orbiagro\Models\Town');
    }
}
