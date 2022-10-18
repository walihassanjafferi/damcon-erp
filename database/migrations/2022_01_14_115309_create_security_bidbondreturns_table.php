<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityBidbondreturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_bidbondreturns', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('pre_security_bid_id')->nullable()->constrained('security_payments')->onDelete('cascade');
            $table->string('customer_name')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->float('amount',16,4);
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_number')->nullable();
            $table->date('cheque_clearing_date')->nullable();
            $table->longText('payment_details')->nullable();
            $table->string('payment_type')->nullable();
            $table->longText('comments')->nullable();
            $table->json('document_file')->nullable();

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
        Schema::dropIfExists('security_bidbondreturns');
    }
}
