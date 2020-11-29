<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use App\Models\BankAccount\Balance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

/**
 * Class DisplayBalances
 *
 * @package App\Http\Livewire\BankAccount
 */
class DisplayBalances extends Component
{
    public BankAccount $bankAccount;

    public bool $createBalance = false;

    public ?string $captured;
    public ?float $value;

    public function render()
    {
        return view('livewire.bank-account.display-balances');
    }

    public function createNewBalance(): void
    {
        $this->captured = Carbon::parse(time())->format('Y-m-d');
        $this->value = 0;

        $this->dispatchBrowserEvent('create-balance');
        $this->createBalance = true;
    }

    public function submitBalance(): void
    {
        $this->validate(
            [
                'captured' => 'required|date|before:tomorrow',
                'value' => 'required|numeric'
            ],
            [
                'required' => 'Das Feld :attribute muss ausgefüllt sein.',
                'date' => 'Das Feld :attribute enthält kein gültiges Datum.',
                'numeric' => 'Das Feld :attribute enthält keine Zahl.',
                'captured.before' => 'Es darf kein Kontostand aus der Zukunft erfasst werden.'
            ],
            [
                'captured' => 'Erfasst am',
                'value' => 'Kontostand'
            ]
        );

        $this->bankAccount->addBalance($this->captured, $this->value);

        $this->emit('created');
        $this->createBalance = false;
    }

    public function deleteBalance(BankAccount\Balance $balance): void
    {
        $balance->delete();

        /** @var Balance $balanceAfter */
        $balanceAfter = Balance::where('bankAccountId', $this->bankAccount->id)
            ->whereDate('captured', '>', $balance->captured)
            ->orderBy('captured')
            ->first();

        if ($balanceAfter instanceof Balance) {
            $balanceAfter->updateDifferences();
        }

        $this->emit('deleted');
    }

    public function getBalancesProperty(): Collection
    {
        return $this->bankAccount->balances()->orderByDesc('captured')->get();
    }
}
