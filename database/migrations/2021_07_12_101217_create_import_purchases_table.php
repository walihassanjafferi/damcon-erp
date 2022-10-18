<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('payment_sending_bank');
            $table->unsignedBigInteger('cash_receiving_bank');
            $table->string('supplier_name');
            $table->string('supplier_ntn_number')->nullable();
            $table->string('supplier_strn_number')->nullable();
            $table->string('invoice_no')->unique()->nullable();
            $table->foreign('tax_id')->references('id')->on('taxation_bodies');
            $table->string('taxation_month');
            $table->string('tax_body_percentage');
            $table->foreign('payment_sending_bank')->references('id')->on('bankaccounts');
            $table->double('sending_amount', 16, 4);
            $table->foreign('cash_receiving_bank')->references('id')->on('bankaccounts');
            $table->double('cash_receiving_amount', 16, 4);
            $table->date('date');
            $table->string('comments');
            $table->string('attachment_of_sales_tax')->nullable();
            $table->string('sales_tax_withheld_at_source_per');
            $table->string('supplier_withheld_tax_1_deduction_per');
            $table->string('damcon_gain_percentage');
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
        Schema::dropIfExists('import_purchases');
    }
}
