<?php

namespace App\Models;

use App\Models\BankAccount\Balance;
use App\Models\BankAccount\Goal;
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
        return $this->hasMany(Balance::class, 'bankAccountId');
    }

    /**
     * @return HasMany
     */
    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'bankAccountId');
    }

    /**
     * This method will return the open goal for this bank account.
     *
     * @return Goal|null
     */
    public function getOpenGoal(): ?Goal
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

        if (!$balance instanceof Balance) {
            $balance = new Balance();
            $balance->bankAccountId = $this->id;
        }

        $balance->captured = $captured;
        $balance->value = $value;
        $balance->differenceDollar = 0;
        $balance->differencePercentage = 0;
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
        $goalObject = new Goal();
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
        return round(
            $this->balances()
                ->selectRaw('AVG(value) AS value')
                ->first()
                ->value,
            2
        );
    }

    /**
     * @return string|null
     */
    public function getAverageBalanceDifferenceDollar(): ?string
    {
        return round(
            $this->balances()
                ->selectRaw('AVG(differenceDollar) AS differenceDollar')
                ->first()
                ->differenceDollar,
            2
        );
    }

    /**
     * @return string|null
     */
    public function getAverageBalanceDifferencePercentage(): ?string
    {
        return round(
            $this->balances()
                ->selectRaw('AVG(differencePercentage) AS differencePercentage')
                ->first()
                ->differencePercentage,
            2
        );
    }
}
