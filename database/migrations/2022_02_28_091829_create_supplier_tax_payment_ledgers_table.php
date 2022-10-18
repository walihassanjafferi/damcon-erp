<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTaxPaymentLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_tax_payment_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_tax_payment_id')->nullable()->constrained('supplier_tax_payments_management')->onDelete('cascade');
            $table->integer('ledger_id')->nullable();
            $table->string('payment_title')->nullable();
            $table->double('tax_ledger_amount')->nullable();


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
        Schema::dropIfExists('supplier_tax_payment_ledgers');
    }
}
