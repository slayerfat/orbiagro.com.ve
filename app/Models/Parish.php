<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;

class Parish extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

    // --------------------------------------------------------------------------
    // Relaciones
    //
    // belongs to
    // --------------------------------------------------------------------------
    public function town()
    {
        return $this->belongsTo('Orbiagro\Models\Town');
    }

    // --------------------------------------------------------------------------
    // has many
    // --------------------------------------------------------------------------
    public function directions()
    {
        return $this->hasMany('Orbiagro\Models\Direction');
    }
}
