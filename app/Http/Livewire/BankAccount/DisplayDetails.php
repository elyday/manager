<?php

namespace App\Http\Livewire\BankAccount;

use App\Models\BankAccount;
use Livewire\Component;

/**
 * Class DisplayDetails
 *
 * @package App\Http\Livewire\BankAccount
 */
class DisplayDetails extends Component
{
    public BankAccount $bankAccount;

    public function render()
    {
        return view('livewire.bank-account.display-details');
    }

    public function polling(): void
    {
        $this->emit('polling');
    }

    public function getAverageBalanceProperty(): string
    {
        return $this->bankAccount->getAverageBalanceValue();
    }

    public function getAverageBalanceDifferenceDollarProperty(): string
    {
        return $this->bankAccount->getAverageBalanceDifferenceDollar();
    }

    public function getAverageBalanceDifferencePercentageProperty(): string
    {
        return $this->bankAccount->getAverageBalanceDifferencePercentage();
    }
}
