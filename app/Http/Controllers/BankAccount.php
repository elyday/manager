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
        return view('bankAccount.viewAll');
    }

    public function view(\App\Models\BankAccount $bankAccount)
    {

        return view(
            'bankAccount.view',
            [
                'bankAccount' => $bankAccount
            ]
        );
    }
}
