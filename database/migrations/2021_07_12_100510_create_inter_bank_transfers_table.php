<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterBankTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inter_bank_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('title_of_transfer');
            $table->unsignedBigInteger('sender_bank_id');
            $table->unsignedBigInteger('receiver_bank_id');
            $table->date('transaction_date')->nullable();
            $table->string('transaction_type');
            $table->string('cheque_no')->nullable();
            $table->foreign('sender_bank_id')->references('id')->on('bankaccounts');
            $table->float('amount',16,2)->nullable();
            $table->foreign('receiver_bank_id')->references('id')->on('bankaccounts');
            $table->string('comments');
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
        Schema::dropIfExists('inter_bank_transfers');
    }
}
