<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

class UserConfirmation extends Model
{

    /**
     * La tabla no posee timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    protected $fillable = [
        'data'
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setDataAttribute()
    {
        $this->attributes['data'] = str_random(32);
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs to
    // --------------------------------------------------------------------------
    public function user()
    {
        return $this->belongsTo('Orbiagro\Models\User');
    }
}
