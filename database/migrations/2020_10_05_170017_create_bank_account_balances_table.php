<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bank_account_balances',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('bankAccountId');
                $table->foreign('bankAccountId')
                    ->references('id')
                    ->on('bank_accounts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->date('captured');
                $table->decimal('value', 13, 2);
                $table->decimal('differenceDollar', 13, 2);
                $table->decimal('differencePercentage', 13, 4);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_account_balances');
    }
}
