<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInvoiceManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invoice_managements', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('title');
            $table->date('date_of_invoicing')->nullable();
            $table->longText('detail_of_invoice')->nullable();
            $table->foreignId('customer_po_id')->constrained('customer_pos_management')->onDelete('cascade');
            $table->float('po_balance',16,4)->nullable();
            $table->string('customer_name')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('invoice_month')->nullable();
            $table->string('region')->nullable();
            $table->foreignId('tax_id')->constrained('taxation_bodies')->onDelete('cascade');
            $table->longText('tax_body_description')->nullable();
            $table->string('taxation_month')->nullable();
            $table->string('tax_body_percentage')->nullable();
            $table->longText('tax_type_comments')->nullable();
            $table->float('penality_deduction_amount',16,4)->nullable();
            $table->longText('penality_deduction_comment')->nullable();
            $table->float('sales_tax_source_percentage',16,4)->nullable();
            $table->float('after_tax_deduction',16,4)->nullable();
            $table->longText('after_tax_deduction_comments')->nullable();
            $table->float('withhold_tax1_percentage',16,4)->nullable();
            $table->float('withhold_tax2_percentage',16,4)->nullable();

            $table->float('sub_total_amount',16,4)->nullable();
            $table->float('before_tax_total',16,4)->nullable();
            $table->float('tax_amount',16,4)->nullable();
            $table->float('total_amount',16,4)->nullable();
            $table->float('sales_tax_wh_at_src',16,4)->nullable();
            $table->float('after_tax_total',16,4)->nullable();
            $table->float('supplier_wh_tax_1',16,4)->nullable();
            $table->float('supplier_wh_tax_2',16,4)->nullable();
            $table->float('net_income',16,4)->nullable();
            $table->float('total_after_deductions',16,4)->nullable();

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
        Schema::dropIfExists('customer_invoice_managements');
    }
}
