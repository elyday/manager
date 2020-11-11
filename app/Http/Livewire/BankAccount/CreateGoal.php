<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use Carbon\Carbon;
use Livewire\Component;

/**
 * Class CreateGoal
 *
 * @package App\Http\Livewire\BankAccount
 */
class CreateGoal extends Component
{
    public BankAccount $bankAccount;

    public ?string $startedAt;
    public ?string $goal;

    public function mount(): void
    {
        $this->startedAt = Carbon::parse(time())->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.bank-account.create-goal');
    }

    public function submit(): void
    {
        $this->validate(
            [
                'startedAt' => 'required|date',
                'goal' => 'required|numeric'
            ],
            [
                'required' => 'Das Feld :attribute muss ausgefüllt sein.',
                'date' => 'Das Feld :attribute enthält kein gültiges Datum.',
                'numeric' => 'Das Feld :attribute enthält keine Zahl.'
            ],
            [
                'startedAt' => 'Startet am',
                'goal' => 'Ziel'
            ]
        );

        $openGoalCount = $this->bankAccount
            ->goals()
            ->whereNull('endedAt')
            ->count();
        $newerGoalCount = $this->bankAccount
            ->goals()
            ->whereDate('startedAt', '>', $this->startedAt)
            ->whereDate('endedAt', '>', $this->startedAt, 'or')
            ->count();

        if ($openGoalCount > 0) {
            request()->session()->flash(
                'errorMessage',
                'Das Ziel konnte nicht erstellt werden: Es ist bereits ein anderes Ziel offen.'
            );
        } elseif ($newerGoalCount > 0) {
            request()->session()->flash(
                'errorMessage',
                'Das Ziel konnte nicht erstellt werden: Es existiert bereits ein Ziel, welches nach diesem gestartet/beendet wurde (Aus Sichtweise des Datums).'
            );
        } else {
            $this->bankAccount->addGoal($this->startedAt, $this->goal);
            request()->session()->flash(
                'successMessage',
                'Ziel wurde erfolgreich erstellt.'
            );
        }

        $this->redirectRoute(
            'bankAccountView',
            ['bankAccount' => $this->bankAccount]
        );
    }
}
