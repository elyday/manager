<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use Carbon\Carbon;
use Livewire\Component;

/**
 * Class CreateBalance
 *
 * @package App\Http\Livewire\BankAccount
 */
class CreateBalance extends Component
{
    public BankAccount $bankAccount;

    public ?string $captured;
    public ?string $value;

    public function mount(): void
    {
        $this->captured = Carbon::parse(time())->format('Y-m-d');
        $this->value = 0;
    }

    public function render()
    {
        return view('livewire.bank-account.create-balance');
    }

    public function submit(): void
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

        request()->session()->flash(
            'successMessage',
            'Kontostand wurde erfolgreich erfasst.'
        );

        $this->redirectRoute(
            'bankAccountView',
            ['bankAccount' => $this->bankAccount]
        );
    }
}
