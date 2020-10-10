<?php

use App\Http\Controllers\BankAccount;
use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('bankaccounts', [BankAccount::class, 'viewAll'])
    ->name('bankAccounts')
    ->middleware(
        ['auth:sanctum', 'verified', 'can:viewAll,App\Model\BankAccount']
    );

Route::prefix('bankaccount')->middleware(['auth:sanctum', 'verified'])->group(
    function () {
        Route::redirect('', '/bankaccounts');

        Route::get('{bankAccount}', [BankAccount::class, 'view'])
            ->name('bankAccountView')
            ->middleware('can:view,bankAccount');

        Route::get('create', [BankAccount::class, 'create'])
            ->name('createBankAccount')
            ->middleware('can:create,App\Models\BankAccount');

        Route::get('{bankAccount}/edit', [BankAccount::class, 'edit'])
            ->name('editBankAccount')
            ->middleware('can:update,bankAccount');

        Route::get('{bankAccount}/delete', [BankAccount::class, 'delete'])
            ->name('deleteBankAccount')
            ->middleware('can:delete,bankAccount');
    }
);

Route::middleware(['auth:sanctum', 'verified'])
    ->name('dashboard')
    ->get('/dashboard', [Dashboard::class, 'dashboard']);

Route::redirect('/', '/dashboard');

Route::prefix('api')
    ->middleware(['auth:sanctum', 'can:view,bankAccount'])
    ->group(
        function () {
            Route::get(
                '/bankAccount/{bankAccount}/balances',
                [
                    \App\Http\Controllers\Api\BankAccount::class,
                    'getBalancesFromBankAccount'
                ]
            );
        }
    );
