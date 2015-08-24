<?php namespace Orbiagro\Models;

use Orbiagro\Models\Bank;
use Orbiagro\Models\User;
use Orbiagro\Models\CardType;
use Illuminate\Database\Eloquent\Model;
use Orbiagro\Mamarrachismo\Traits\InternalDBManagement;

/**
 * Orbiagro\Models\Billing
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
 * @property-read \Orbiagro\Models\Bank $bank
 * @property-read \Orbiagro\Models\CardType $cardType
 * @property-read \Orbiagro\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereBankId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereCardTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereCardNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereBankAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereExpiration($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereComments($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\Orbiagro\Models\Billing whereUpdatedBy($value)
 */
class Billing extends Model
{

    use InternalDBManagement;

    // --------------------------------------------------------------------------
    // Relaciones
    // --------------------------------------------------------------------------

    /**
     * @return Bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * @return CardType
     */
    public function cardType()
    {
        return $this->belongsTo(CardType::class);
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
