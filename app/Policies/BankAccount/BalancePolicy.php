<?php

namespace App\Policies\BankAccount;

use App\Models\BankAccount\Balance;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class BalancePolicy
 *
 * @package App\Policies\BankAccount
 */
class BalancePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'view');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankAccount\Balance  $balance
     * @return mixed
     */
    public function view(User $user, Balance $balance)
    {
        return $user->hasTeamPermission($user->currentTeam, 'view')
            && $balance->bankAccount()->teamId === $user->currentTeam->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankAccount\Balance  $balance
     * @return mixed
     */
    public function update(User $user, Balance $balance)
    {
        return $user->hasTeamPermission($user->currentTeam, 'create')
            && $balance->bankAccount()->first()->teamId === $user->currentTeam->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\BankAccount\Balance  $balance
     * @return mixed
     */
    public function delete(User $user, Balance $balance)
    {
        return $user->hasTeamPermission($user->currentTeam, 'delete')
            && $balance->bankAccount()->first()->teamId === $user->currentTeam->id;
    }
}