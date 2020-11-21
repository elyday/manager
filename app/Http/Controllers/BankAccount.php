<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;

/**
 * Class BankAccount
 *
 * @package App\Http\Controllers
 */
class BankAccount extends Controller
{
    public function viewAll()
    {
        $bankAccounts = \App\Models\BankAccount::where('teamId', Auth::user()->currentTeam->id)->get();

        return view(
            'bankAccount.viewAll',
            ['pageTitle' => 'Bankkonten', 'bankAccounts' => $bankAccounts]
        );
    }

    public function view(\App\Models\BankAccount $bankAccount)
    {
        $balances = $bankAccount->balances()->orderBy('captured')->get();

        return view(
            'bankAccount.view',
            [
                'pageTitle' => 'Bankkonto "' . $bankAccount->name . '"',
                'bankAccount' => $bankAccount,
                'balances' => $balances
            ]
        );
    }

    public function create()
    {
        return view(
            'bankAccount.manage',
            [
                'pageTitle' => 'Bankkonto erstellen',
                'bankAccount' => null
            ]
        );
    }

    public function edit(\App\Models\BankAccount $bankAccount)
    {
        return view(
            'bankAccount.manage',
            [
                'pageTitle' => 'Bankkonto "' . $bankAccount->name . '" bearbeiten',
                'bankAccount' => $bankAccount
            ]
        );
    }

    public function delete(\App\Models\BankAccount $bankAccount)
    {
        return view(
            'bankAccount.delete',
            [
                'pageTitle' => 'Bankkonto "' . $bankAccount->name . '" löschen',
                'bankAccount' => $bankAccount
            ]
        );
    }
}
