<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * Class BankAccountBalance
 *
 * @package App\Models
 *
 * @property int    $id
 * @property int    $bankAccountId
 * @property string $captured
 * @property float  $value
 * @property float  $differenceDollar
 * @property float  $differencePercentage
 */
class BankAccountBalance extends Model
{
    use HasFactory;

    public function updateDifferences(): void
    {
        /** @var self $balanceBefore */
        $balanceBefore = self::where('bankAccountId', $this->bankAccountId)
            ->whereDate('captured', '<', $this->captured)
            ->orderByDesc('captured')
            ->first();

        /** @var self $balanceAfter */
        $balanceAfter = self::where('bankAccountId', $this->bankAccountId)
            ->whereDate('captured', '>', $this->captured)
            ->orderBy('captured')
            ->first();

        if (!$balanceBefore instanceof self) {
            $this->differenceDollar = 0;
            $this->differencePercentage = 0;
        } else {
            $this->differenceDollar = bcsub(
                $this->value,
                $balanceBefore->value,
                2
            );

            $this->differencePercentage = bcmul(
                bcsub(
                    bcdiv(
                        $this->value,
                        $balanceBefore->value,
                        4
                    ),
                    1,
                    4
                ),
                100,
                4
            );
        }


        $this->save();

        if ($balanceAfter instanceof self) {
            $balanceAfter->updateDifferences();
        }
    }
}
