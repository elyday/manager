<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class BankAccount
 *
 * @package App\Models
 *
 * @property int    $id
 * @property int    $teamId
 * @property string $name
 * @property string $accountNumber
 */
class BankAccount extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function balances(): HasMany
    {
        return $this->hasMany(BankAccountBalance::class, 'bankAccountId');
    }

    /**
     * This method will add a new balance to this bank account. If there is
     * already an existing balance on the captured date it will be updated.
     *
     * @param  string  $captured
     * @param  float   $value
     */
    public function addBalance(string $captured, float $value): void
    {
        $balance = $this->balances()->where('captured', $captured)->first();

        if (!$balance instanceof BankAccountBalance) {
            $balance = new BankAccountBalance();
            $balance->bankAccountId = $this->id;
        }

        $balance->captured = $captured;
        $balance->value = $value;
        $balance->updateDifferences();
        $balance->save();
    }
}
