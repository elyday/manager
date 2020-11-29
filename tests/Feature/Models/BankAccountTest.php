<?php

namespace Tests\Feature\Models;

use App\Models\BankAccount;
use Database\Seeders\TeamSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BankAccountTest
 *
 * @package Tests\Feature
 */
class BankAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array  $balances
     * @param  float  $expectedAverageBalance
     * @param  float  $expectedAverageBalanceDifferenceDollar
     * @param  float  $expectedAverageBalanceDifferencePercentage
     *
     * @dataProvider balanceAverageCalculationDataProvider
     */
    public function testBalanceAverageCalculation(
        array $balances,
        float $expectedAverageBalance,
        float $expectedAverageBalanceDifferenceDollar,
        float $expectedAverageBalanceDifferencePercentage
    ): void {
        $this->seed(TeamSeeder::class);
        $this->assertDatabaseCount('teams', 1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        foreach ($balances as $balance) {
            $bankAccount->addBalance($balance['captured'], $balance['value']);
        }

        self::assertEquals(
            $expectedAverageBalance,
            $bankAccount->getAverageBalanceValue()
        );
        self::assertEquals(
            $expectedAverageBalanceDifferenceDollar,
            $bankAccount->getAverageBalanceDifferenceDollar()
        );
        self::assertEquals(
            $expectedAverageBalanceDifferencePercentage,
            $bankAccount->getAverageBalanceDifferencePercentage()
        );
    }

    /**
     * @return array
     */
    public function balanceAverageCalculationDataProvider(): array
    {
        return [
            [
                'balances' => [
                    [
                        'captured' => '2020-01-01',
                        'value' => 250
                    ],
                    [
                        'captured' => '2020-01-02',
                        'value' => 1000
                    ]
                ],
                'expectedAverageBalance' => 625,
                'expectedAverageBalanceDifferenceDollar' => 375,
                'expectedAverageBalanceDifferencePercentage' => 150
            ],
            [
                'balances' => [
                    [
                        'captured' => '2020-01-01',
                        'value' => 1
                    ],
                    [
                        'captured' => '2020-01-02',
                        'value' => 500
                    ],
                    [
                        'captured' => '2020-01-03',
                        'value' => 3080
                    ]
                ],
                'expectedAverageBalance' => 1193.67,
                'expectedAverageBalanceDifferenceDollar' => 1026.33,
                'expectedAverageBalanceDifferencePercentage' => 16805.33
            ]
        ];
    }
}
