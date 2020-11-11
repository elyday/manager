<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

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
     * @return HasMany
     */
    public function goals(): HasMany
    {
        return $this->hasMany(BankAccountGoal::class, 'bankAccountId');
    }

    /**
     * This method will return the open goal for this bank account.
     *
     * @return BankAccountGoal|null
     */
    public function getOpenGoal(): ?BankAccountGoal
    {
        return $this->goals()->whereNull('endedAt')->first();
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
        $balance->save();

        $balance->updateDifferences();

        $openGoal = $this->getOpenGoal();
        if ($openGoal !== null) {
            $openGoal->updateLastBalance();
            $openGoal->save();
        }
    }

    /**
     * @param  string  $startedAt
     * @param  float   $goal
     */
    public function addGoal(string $startedAt, float $goal): void
    {
        $goalObject = new BankAccountGoal();
        $goalObject->bankAccountId = $this->id;
        $goalObject->startedAt = $startedAt;
        $goalObject->goal = $goal;
        $goalObject->updateLastBalance();
        $goalObject->save();
    }

    /**
     * @return string|null
     */
    public function getAverageBalanceValue(): ?string
    {
        return $this->balances()
            ->selectRaw('AVG(value) AS value')
            ->first()
            ->value;
    }

    /**
     * @return string|null
     */
    public function getAverageBalanceDifferenceDollar(): ?string
    {
        return $this->balances()
            ->selectRaw('AVG(differenceDollar) AS differenceDollar')
            ->first()
            ->differenceDollar;
    }

    /**
     * @return string|null
     */
    public function getAverageBalanceDifferencePercentage(): ?string
    {
        return $this->balances()
            ->selectRaw('AVG(differencePercentage) AS differencePercentage')
            ->first()
            ->differencePercentage;
    }
}
