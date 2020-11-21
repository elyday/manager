<?php

namespace Tests\Feature\Controller\Api;

use App\Models\BankAccount;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\TeamSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class BankAccountTest
 *
 * @package Tests\Feature\Controller\Api
 */
class BankAccountTest extends TestCase
{
    use RefreshDatabase;

    public function testBalancesResponse(): void
    {
        $this->seed(TeamSeeder::class);

        /** @var User $user */
        $user = User::find(1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        $bankAccount->addBalance('2020-01-01', 400);
        $bankAccount->addBalance('2020-01-02', 1000);
        $bankAccount->addBalance('2020-01-03', 350);

        $response = $this->actingAs($user, 'sanctum')
            ->get(
                '/api/bankAccount/' . $bankAccount->id . '/balances'
            );

        $response->assertStatus(200);
        $response->assertJson(
            [
                'line' => [
                    [
                        'x' => Carbon::parse('2020-01-01')->getPreciseTimestamp(3),
                        'y' => 400
                    ],
                    [
                        'x' => Carbon::parse('2020-01-02')->getPreciseTimestamp(3),
                        'y' => 1000
                    ],
                    [
                        'x' => Carbon::parse('2020-01-03')->getPreciseTimestamp(3),
                        'y' => 350
                    ]
                ]
            ]
        );
        $response->assertJson(
            [
                'column' => [
                    [
                        'x' => Carbon::parse('2020-01-01')->getPreciseTimestamp(3),
                        'y' => 0
                    ],
                    [
                        'x' => Carbon::parse('2020-01-02')->getPreciseTimestamp(3),
                        'y' => 600
                    ],
                    [
                        'x' => Carbon::parse('2020-01-03')->getPreciseTimestamp(3),
                        'y' => -650
                    ]
                ]
            ]
        );
    }
}
