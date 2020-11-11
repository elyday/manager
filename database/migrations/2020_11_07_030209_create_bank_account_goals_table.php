<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'bank_account_goals',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('bankAccountId');
                $table->foreign('bankAccountId')
                    ->references('id')
                    ->on('bank_accounts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                $table->date('startedAt');
                $table->date('endedAt')->nullable();
                $table->decimal('goal', 13, 2);
                $table->decimal('lastBalance', 13, 2);
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
        Schema::dropIfExists('bank_account_goals');
    }
}
