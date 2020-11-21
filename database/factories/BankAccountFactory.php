<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BankAccountFactory
 *
 * @package Database\Factories
 */
class BankAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'teamId' => 1,
            'name' => 'Test Konto',
            'accountNumber' => $this->faker->bankAccountNumber
        ];
    }
}
