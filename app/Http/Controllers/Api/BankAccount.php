<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankAccount\Balance;
use Carbon\Carbon;

/**
 * Class BankAccount
 *
 * @package App\Http\Controllers\Api
 */
class BankAccount extends Controller
{
    public function getBalancesFromBankAccount(
        \App\Models\BankAccount $bankAccount
    ) {
        $balances = $bankAccount->balances()->orderBy('captured')->get();
        $result = ['line' => [], 'bar' => []];

        /** @var Balance $balance */
        foreach ($balances as $balance) {
            $result['line'][] = [
                'x' => Carbon::parse($balance->captured)->getPreciseTimestamp(3),
                'y' => (float)$balance->value
            ];

            $result['column'][] = [
                'x' => Carbon::parse($balance->captured)->getPreciseTimestamp(3),
                'y' => (float)$balance->differenceDollar
            ];
        }

        return response()->json($result);
    }
}