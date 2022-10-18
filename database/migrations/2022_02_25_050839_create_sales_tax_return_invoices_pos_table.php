<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTaxReturnInvoicesPosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_tax_return_invoices_pos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_tax_return_id')->nullable()->constrained('salestaxreturnmanagements')->onDelete('cascade');
            $table->string('invoice_po_id')->nullable();
            $table->string('type')->nullable();
            $table->double('amount')->nullable();
            $table->double('adjusted_input_output')->nullable();
            $table->foreignId('tax_id')->nullable()->constrained('Taxation_bodies')->onDelete('cascade');
            $table->string('taxation_month')->nullable();
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
        Schema::dropIfExists('sales_tax_return_invoices_pos');
    }
}
