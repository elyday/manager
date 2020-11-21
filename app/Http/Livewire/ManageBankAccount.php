<?php

namespace App\Http\Livewire;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Class ManageBankAccount
 *
 * @package App\Http\Livewire
 */
class ManageBankAccount extends Component
{
    public ?BankAccount $account;
    public ?string $name;
    public ?string $accountNumber;

    public function mount($bankAccount): void
    {
        if ($bankAccount instanceof BankAccount) {
            $this->name = $bankAccount->name;
            $this->accountNumber = $bankAccount->accountNumber;
            $this->account = $bankAccount;
        }
    }

    public function render()
    {
        return view('livewire.manage-bank-account');
    }

    public function submit(): void
    {
        $this->validate(
            [
                'name' => 'required|max:50',
                'accountNumber' => 'required|max:15'
            ],
            [
                'required' => 'Das Feld :attribute muss ausgefüllt sein.',
                'max' => 'Das Feld :attribute darf nicht länger als :max Zeichen sein.'
            ],
            [
                'name' => 'Name',
                'accountNumber' => 'Konto Nr.'
            ]
        );

        if (!$this->account instanceof BankAccount) {
            $this->account = new BankAccount();
            $this->account->teamId = Auth::user()->currentTeam->id;
        }

        $this->account->name = $this->name;
        $this->account->accountNumber = $this->accountNumber;
        $this->account->save();

        request()->session()->flash(
            'successMessage',
            'Das Bankkonto ist erfolgreich gespeichert worden.'
        );

        $this->redirectRoute('bankAccounts');
    }
}
