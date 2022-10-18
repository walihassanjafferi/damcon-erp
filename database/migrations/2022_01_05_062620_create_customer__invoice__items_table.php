<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer__invoice__items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_invoice_management_id')->constrained('customer_invoice_managements')->onDelete('cascade');
            $table->longText('item_name');
            $table->integer('item_qunatity');
            $table->string('item_cost');
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
        Schema::dropIfExists('customer__invoice__items');
    }
}
