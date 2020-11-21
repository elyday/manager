<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use App\Models\BankAccount\Goal;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

/**
 * Class DisplayGoals
 *
 * @package App\Http\Livewire\BankAccount
 */
class DisplayGoals extends Component
{
    public BankAccount $bankAccount;

    public Collection $goals;

    public function mount(): void
    {
        $this->goals = $this->bankAccount->goals()
            ->orderByDesc('startedAt')
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.bank-account.display-goals');
    }

    public function completeGoal(int $goalId): void
    {
        /** @var Goal $goal */
        $goal = $this->bankAccount->goals()->where('id', $goalId)->first();

        if ($goal->endedAt !== null) {
            request()->session()->flash(
                'errorMessage',
                'Dieses Ziel kann nicht abgeschlossen werden.'
            );
        } else {
            $goal->endedAt = Carbon::now()->format('Y-m-d');
            $goal->updateLastBalance();
            $goal->save();

            request()->session()->flash(
                'successMessage',
                'Das Ziel wurde erfolgreich abgeschlossen.'
            );
        }

        $this->redirectRoute(
            'bankAccountView',
            ['bankAccount' => $this->bankAccount]
        );
    }

    public function deleteGoal(int $goalId): void
    {
        /** @var Goal $goal */
        $goal = $this->bankAccount->goals()->where('id', $goalId)->first();
        $goal->delete();

        request()->session()->flash(
            'successMessage',
            'Das Ziel wurde erfolgreich gelöscht.'
        );

        $this->redirectRoute(
            'bankAccountView',
            ['bankAccount' => $this->bankAccount]
        );
    }
}
