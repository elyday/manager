<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Class ViewAll
 *
 * @package App\Http\Livewire\BankAccount
 */
class ViewAll extends Component
{
    public ?BankAccount $bankAccount = null;
    public bool $editingBankAccount = false;
    public bool $deletingBankAccount = false;

    public ?string $name;
    public ?string $accountNumber;

    public function render()
    {
        return view('livewire.bank-account.view-all');
    }

    public function getTitleProperty(): string
    {
        return collect(
            $this->bankAccount instanceof BankAccount ? 'Bankkonto bearbeiten'
                : 'Bankkonto erstellen'
        )->first(function ($string) { return $string; });
    }

    public function getBankAccountNameProperty(): string
    {
        return collect(
            $this->bankAccount instanceof BankAccount ? $this->bankAccount->name
                : '-'
        )->first(function ($string) { return $string; });
    }

    public function getAccountsProperty()
    {
        return collect(
            BankAccount::where('teamId', Auth::user()->currentTeam->id)->get()
        )->map(function ($account) { return $account; });
    }

    public function createNewBankAccount(): void
    {
        $this->bankAccount = null;
        $this->name = '';
        $this->accountNumber = '';

        $this->dispatchBrowserEvent('edit-bank-account');
        $this->deletingBankAccount = false;
        $this->editingBankAccount = true;
    }

    /**
     * @param  BankAccount  $bankAccount
     */
    public function editBankAccount(BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;
        $this->name = $bankAccount->name;
        $this->accountNumber = $bankAccount->accountNumber;

        $this->dispatchBrowserEvent('edit-bank-account');
        $this->deletingBankAccount = false;
        $this->editingBankAccount = true;
    }

    /**
     * @param  BankAccount  $bankAccount
     */
    public function deleteBankAccount(BankAccount $bankAccount): void
    {
        $this->bankAccount = $bankAccount;

        $this->dispatchBrowserEvent('delete-bank-account');
        $this->editingBankAccount = false;
        $this->deletingBankAccount = true;
    }

    public function submitBankAccount(): void
    {
        $this->resetErrorBag();

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

        if (!$this->bankAccount instanceof BankAccount) {
            $this->bankAccount = new BankAccount();
            $this->bankAccount->teamId = Auth::user()->currentTeam->id;
        }

        $this->bankAccount->name = $this->name;
        $this->bankAccount->accountNumber = $this->accountNumber;
        $this->bankAccount->save();

        $this->deletingBankAccount = false;
        $this->editingBankAccount = false;
        $this->emit('saved');
    }

    public function submitDeleteBankAccount(): void
    {
        $this->resetErrorBag();

        if (!Auth::user()->hasTeamPermission(
            Auth::user()->currentTeam,
            'delete'
        )
        ) {
            $this->redirectRoute('bankAccounts');
        }

        $this->bankAccount->delete();

        $this->deletingBankAccount = false;
        $this->editingBankAccount = false;
        $this->emit('deleted');
    }
}
