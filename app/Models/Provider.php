<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\CanSearchRandomly;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Provider
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $url
 * @property string $contact_name
 * @property string $contact_title
 * @property string $contact_email
 * @property string $contact_phone_1
 * @property string $contact_phone_2
 * @property string $contact_phone_3
 * @property string $contact_phone_4
 * @property string $email
 * @property string $phone_1
 * @property string $phone_2
 * @property string $phone_3
 * @property string $phone_4
 * @property string $trust
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactPhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactPhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactPhone3($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereContactPhone4($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider wherePhone3($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider wherePhone4($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereTrust($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Provider random()
 */
class Provider extends Model
{

    use InternalDBManagement, CanSearchRandomly;

    protected $fillable = [
        'name',
        'slug',
        'url',
        'contact_name',
        'contact_title',
        'contact_email',
        'contact_phone_1',
        'contact_phone_2',
        'contact_phone_3',
        'contact_phone_4',
        'email',
        'phone_1',
        'phone_2',
        'phone_3',
        'phone_4',
        'trust'
    ];

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ModelValidation::byLenght($value);

        if ($this->attributes['name'] !== null) {
            $this->attributes['slug'] = str_slug($this->attributes['name']);
        }
    }

    public function setSlugAttribute($value)
    {
        if (ModelValidation::byLenght($value) !== null) {
            return $this->attributes['slug'] = str_slug($value);
        }

        return $this->attributes['slug'] = null;
    }

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    // --------------------------------------------------------------------------
    // Scopes
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To Many
    // --------------------------------------------------------------------------
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('sku');
    }
}
