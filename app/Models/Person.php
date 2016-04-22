<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\ModelValidation;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Person
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $gender_id
 * @property integer $nationality_id
 * @property string $first_name
 * @property string $last_name
 * @property string $first_surname
 * @property string $last_surname
 * @property string $identity_card
 * @property string $phone
 * @property string $birth_date
 * @property integer $created_by
 * @property integer $updated_by
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $first_sur_name
 * @property-read mixed $last_sur_name
 * @property-read \Orbiagro\Models\Gender $gender
 * @property-read \Orbiagro\Models\Nationality $nationality
 * @property-read \Orbiagro\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Orbiagro\Models\Direction[] $direction
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereGenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereNationalityId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereFirstSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereLastSurname($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereIdentityCard($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereBirthDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Person whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Person extends Model
{

    use InternalDBManagement;

    protected $fillable = [
        'first_name',
        'last_name',
        'first_surname',
        'last_surname',
        'identity_card',
        'phone',
        'birth_date'
    ];

    // --------------------------------------------------------------------------
    // Accessors
    // --------------------------------------------------------------------------
    public function getFirstNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    public function getLastNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    public function getFirstSurNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    public function getLastSurNameAttribute($value)
    {
        if ($value) {
            return ucfirst($value);
        }

        return null;
    }

    public function formattedNames()
    {
        if (isset($this->attributes['first_name'])
        && isset($this->attributes['first_surname'])) {
            return ucfirst($this->attributes['first_name'])
                .' '
                .ucfirst($this->attributes['first_surname']);

        } elseif (isset($this->attributes['first_name'])) {
            return ucfirst($this->attributes['first_name']);
        }

        return null;
    }

    public function getPhoneAttribute($value)
    {
        return ModelValidation::parsePhone($value);
    }

    // --------------------------------------------------------------------------
    // Mutators
    // --------------------------------------------------------------------------
    public function setIdentityCardAttribute($value)
    {
        $this->attributes['identity_card'] = ModelValidation::byNonNegative($value);
    }

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ModelValidation::byLenght($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ModelValidation::byLenght($value);
    }

    public function setFirstSurnameAttribute($value)
    {
        $this->attributes['first_surname'] = ModelValidation::byLenght($value);
    }

    public function setLastSurnameAttribute($value)
    {
        $this->attributes['last_surname'] = ModelValidation::byLenght($value);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = ModelValidation::parseRawPhone($value);
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = ModelValidation::byLenght($value);
    }

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    // --------------------------------------------------------------------------
    // Belongs To
    // --------------------------------------------------------------------------
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --------------------------------------------------------------------------
    // Polimorfica
    // --------------------------------------------------------------------------
    public function direction()
    {
        return $this->morphMany(Direction::class, 'directionable');
    }
}
