<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

class Town extends Model
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

    public function state()
    {
        return $this->belongsTo('Orbiagro\Models\State');
    }

    public function parishes()
    {
        return $this->hasMany('Orbiagro\Models\Parish');
    }
}
