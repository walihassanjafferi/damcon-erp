<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalestaxreturnmanagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salestaxreturnmanagements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_id')->nullable()->constrained('Taxation_bodies')->onDelete('cascade');
            $table->string('taxation_month')->nullable();
            $table->double('payable_taxbody');
            $table->double('manual_adjustments');
            $table->longText('manual_adjustment_comments')->nullable();
            $table->double('net_payable');
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->foreignId('batch_payment_management_id')->nullable()->constrained('batch_payments_management')->onDelete('cascade');
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('date')->nullable();
            $table->double('amount');
            $table->longText('payment_details')->nullable();
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
        Schema::dropIfExists('salestaxreturnmanagements');
    }
}
