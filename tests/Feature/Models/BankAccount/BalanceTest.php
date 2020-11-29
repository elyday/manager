<?php

namespace Tests\Feature\Models\BankAccount;

use App\Models\BankAccount;
use Database\Seeders\TeamSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BankAccountBalanceTest
 *
 * @package Tests\Feature
 */
class BalanceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param  array  $balances
     *
     * @dataProvider createBalanceDataProvider
     */
    public function testCreateBalance(array $balances): void
    {
        $this->seed(TeamSeeder::class);
        $this->assertDatabaseCount('teams', 1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        foreach ($balances as $balance) {
            $bankAccount->addBalance($balance['captured'], $balance['value']);
        }

        $this->assertDatabaseCount('bank_account_balances', count($balances));
    }

    public function testCreateBalanceBetweenTwoBalances(): void
    {
        $this->seed(TeamSeeder::class);
        $this->assertDatabaseCount('teams', 1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        $bankAccount->addBalance('2020-01-01', 100);
        $bankAccount->addBalance('2020-01-03', 500);
        $bankAccount->addBalance('2020-01-02', 200);

        $this->assertDatabaseCount('bank_account_balances', 3);
        $this->assertDatabaseHas(
            'bank_account_balances',
            [
                'captured' => '2020-01-02',
                'value' => 200,
                'differenceDollar' => 100,
                'differencePercentage' => 100
            ]
        );
        $this->assertDatabaseHas(
            'bank_account_balances',
            [
                'captured' => '2020-01-03',
                'value' => 500,
                'differenceDollar' => 300,
                'differencePercentage' => 150
            ]
        );
    }

    /**
     * @return array
     */
    public function createBalanceDataProvider(): array
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
                ]
            ],
            [
                'balances' => [
                    [
                        'captured' => '2020-01-01',
                        'value' => 400
                    ],
                    [
                        'captured' => '2020-01-02',
                        'value' => 800
                    ],
                    [
                        'captured' => '2020-01-03',
                        'value' => 74569
                    ]
                ]
            ]
        ];
    }
}
