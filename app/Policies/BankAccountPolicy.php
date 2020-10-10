<?php

namespace App\Policies;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankAccountPolicy
{
    use HandlesAuthorization;

    public function viewAll(User $user)
    {
        return $user->hasTeamPermission($user->currentTeam, 'view');
    }

    public function view(User $user, BankAccount $bankAccount): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'view')
            && $bankAccount->teamId === $user->currentTeam->id;
    }

    public function create(User $user): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'create');
    }

    public function update(User $user, BankAccount $bankAccount): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'update')
            && $bankAccount->teamId === $user->currentTeam->id;
    }

    public function delete(User $user, BankAccount $bankAccount): bool
    {
        return $user->hasTeamPermission($user->currentTeam, 'delete')
            && $bankAccount->teamId === $user->currentTeam->id;
    }
}