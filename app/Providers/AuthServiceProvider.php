<?php

namespace App\Providers;

use App\Models\BankAccount;
use App\Models\BankAccount\Goal;
use App\Models\Team;
use App\Policies\BankAccount\BalancePolicy;
use App\Policies\BankAccount\GoalPolicy;
use App\Policies\BankAccountPolicy;
use App\Policies\TeamPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 *
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        BankAccount::class => BankAccountPolicy::class,
        Goal::class => GoalPolicy::class,
        BankAccount\Balance::class => BalancePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
