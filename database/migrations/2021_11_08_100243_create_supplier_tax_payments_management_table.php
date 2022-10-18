<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTaxPaymentsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_tax_payments_management', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->double('payable_tax')->nullable();
            $table->double('manual_adjustments')->nullable();
            $table->double('final_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('date')->nullable();
            $table->longText('manual_adjustment_comments')->nullable();
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
        Schema::dropIfExists('supplier_tax_payments_management');
    }
}
