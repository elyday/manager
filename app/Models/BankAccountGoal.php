<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BankAccountGoal
 *
 * @package App\Models
 *
 * @property int    $id
 * @property int    $bankAccountId
 * @property string $startedAt
 * @property string $endedAt
 * @property float  $goal
 * @property float  $lastBalance
 */
class BankAccountGoal extends Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class, 'bankAccountId');
    }

    /**
     * This method will calculate the reached goal.
     *
     * @return float
     */
    public function calculateReachedPercentage(): float
    {
        return round(
            bcmul(
                bcdiv(
                    $this->lastBalance,
                    $this->goal,
                    50
                ),
                100,
                50
            ),
            2
        );
    }

    /**
     * This method will get the last captured bank account balance and save
     * its value to this goal as last balance.
     */
    public function updateLastBalance(): void
    {
        /** @var BankAccount $bankAccount */
        $bankAccount = $this->bankAccount()->first();
        /** @var BankAccountBalance $balance */
        $balance = $bankAccount->balances()->orderByDesc('captured')->first();

        if ($balance instanceof BankAccountBalance) {
            $this->lastBalance = $balance->value;
        } else {
            $this->lastBalance = 0;
        }
    }
}
