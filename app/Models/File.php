<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\File
 *
 * @property integer $id
 * @property integer $fileable_id
 * @property string $fileable_type
 * @property string $path
 * @property string $mime
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \ $filable
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereFileableId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereFileableType($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File wherePath($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereMime($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\File whereUpdatedBy($value)
 */
class File extends Model
{

    use InternalDBManagement;

    protected $fillable = ['path', 'mime'];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setPathAttribute($value)
    {
        if ($this->fileExists($value)) {
            return $this->attributes['path'] = $value;
        }

        return $this->attributes['path'] = null;
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getPathAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return null;
    }

    /**
     * Relacion polimorfica
     * http://www.easylaravelbook.com/blog/2015/01/21/creating-polymorphic-relations-in-laravel-5/
     */
    public function filable()
    {
        return $this->morphTo();
    }

    // --------------------------------------------------------------------------
    // Private Methods
    // --------------------------------------------------------------------------

    /**
     * @param string $path
     *
     * @return boolean
     */
    private function fileExists($path)
    {
        if (Storage::disk('public')->exists($path)) {
            return true;
        } elseif (Storage::disk('test')->exists($path)) {
            return true;
        }

        return false;
    }
}
