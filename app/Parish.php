<?php namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Mamarrachismo\Traits\InternalDBManagement;
use App\Mamarrachismo\Traits\CanSearchRandomly;

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
        return $this->belongsTo('App\Town');
    }

    // --------------------------------------------------------------------------
    // has many
    // --------------------------------------------------------------------------
    public function directions()
    {
        return $this->hasMany('App\Direction');
    }
}
