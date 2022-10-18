<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained('bankaccounts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('transaction_type')->nullable();
            $table->float('transfer_amount',16,4)->nullable();
            $table->longText('comments')->nullable();
            $table->string('transaction_type')->nullable();
            $table->float('withdraw_amount',16,4)->nullable();
            $table->float('deposit_amount',16,4)->nullable();
            $table->float('remaining_balance',16,4)->nullable();
            $table->string('payment_title')->nullable();
            $table->longText('comments')->nullable();
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_transactions');
    }
}
