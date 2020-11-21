<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Class Delete
 *
 * @package App\Http\Livewire\BankAccount
 */
class Delete extends Component
{
    public BankAccount $bankAccount;

    public function render()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user->hasTeamPermission($user->currentTeam, 'delete')) {
            $this->request->session()->flash(
                'errorMessage',
                'Du hast keine Berechtigung dies zu tun.'
            );
            $this->redirectRoute('bankAccounts');
        }

        return view('livewire.bank-account.delete');
    }

    public function submit(): void
    {
        $this->bankAccount->delete();

        request()->session()->flash(
            'successMessage',
            'Das Bankkonto ist erfolgreich gelöscht worden.'
        );

        $this->redirectRoute('bankAccounts');
    }
}
