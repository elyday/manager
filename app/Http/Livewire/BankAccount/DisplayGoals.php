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

    public bool $createGoal = false;

    public ?string $startedAt;
    public ?float $goal;

    public function render()
    {
        return view('livewire.bank-account.display-goals');
    }

    public function createNewGoal(): void
    {
        $this->startedAt = Carbon::parse(time())->format('Y-m-d');
        $this->goal = 0;

        $this->dispatchBrowserEvent('create-goal');
        $this->createGoal = true;
    }

    public function submitGoal(): void
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
            $this->addError(
                'startedAt',
                'Das Ziel konnte nicht erstellt werden: Es ist bereits ein anderes Ziel offen.'
            );

            return;
        }

        if ($newerGoalCount > 0) {
            $this->addError(
                'startedAt',
                'Das Ziel konnte nicht erstellt werden: Es existiert bereits ein Ziel, welches nach diesem gestartet/beendet wurde (Aus Sichtweise des Datums).'
            );

            return;
        }

        $this->bankAccount->addGoal($this->startedAt, $this->goal);

        $this->createGoal = false;
        $this->emit('created');
    }

    public function completeGoal(Goal $goal): void
    {
        if ($goal->endedAt === null) {
            $goal->endedAt = Carbon::now()->format('Y-m-d');
            $goal->updateLastBalance();
            $goal->save();

            $this->emit('completed');
        }
    }

    public function deleteGoal(Goal $goal): void
    {
        $goal->delete();

        $this->emit('deleted');
    }

    /**
     * @return Collection
     */
    public function getGoalsProperty(): Collection
    {
        return $this->bankAccount->goals()
            ->orderByDesc('startedAt')
            ->orderByDesc('created_at')
            ->get();
    }
}
