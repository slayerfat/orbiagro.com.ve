<?php namespace Orbiagro\Models;

use Illuminate\Database\Eloquent\Model;

use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * App\Billing
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $bank_id
 * @property integer $card_type_id
 * @property string $card_number
 * @property string $bank_account
 * @property string $expiration
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property-read \App\Bank $bank
 * @property-read \App\CardType $cardType
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereBankId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCardTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCardNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereBankAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereExpiration($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Billing whereUpdatedBy($value)
 */
class Billing extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    /**
     * @property-read \App\Bank $bank
     *
     * @return \App\Bank
     */
    public function bank()
    {
        return $this->belongsTo('App\Bank');
    }

    /**
     * @property-read \App\CardType $cardType
     *
     * @return \App\CardType
     */
    public function cardType()
    {
        return $this->belongsTo('App\CardType');
    }

    /**
     * @property-read \App\User $user
     *
     * @return \App\User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
