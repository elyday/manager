<?php

namespace Tests\Feature\Models\BankAccount;

use App\Models\BankAccount;
use Database\Seeders\TeamSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class GoalTest
 *
 * @package Tests\Feature
 */
class GoalTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateGoal(): void
    {
        $this->seed(TeamSeeder::class);
        $this->assertDatabaseCount('teams', 1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        $bankAccount->addGoal('2020-01-01', 500);
        $this->assertDatabaseCount('bank_account_goals', 1);
        $this->assertDatabaseHas(
            'bank_account_goals',
            [
                'startedAt' => '2020-01-01',
                'endedAt' => null,
                'goal' => 500,
                'lastBalance' => 0
            ]
        );
    }

    public function testCreateGoalAndAddNewBalance(): void
    {
        $this->seed(TeamSeeder::class);
        $this->assertDatabaseCount('teams', 1);

        /** @var BankAccount $bankAccount */
        $bankAccount = BankAccount::factory()->create();
        $this->assertDatabaseCount('bank_accounts', 1);

        $bankAccount->addGoal('2020-01-01', 500);
        $this->assertDatabaseCount('bank_account_goals', 1);
        $this->assertDatabaseHas(
            'bank_account_goals',
            [
                'startedAt' => '2020-01-01',
                'endedAt' => null,
                'goal' => 500,
                'lastBalance' => 0
            ]
        );

        $bankAccount->addBalance('2020-01-01', 240);
        $this->assertDatabaseHas(
            'bank_account_goals',
            [
                'startedAt' => '2020-01-01',
                'endedAt' => null,
                'goal' => 500,
                'lastBalance' => 240
            ]
        );

        $goal = $bankAccount->getOpenGoal();
        self::assertEquals(48, $goal->calculateReachedPercentage());
    }
}
