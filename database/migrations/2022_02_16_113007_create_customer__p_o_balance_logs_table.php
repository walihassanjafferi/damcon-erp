<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPOBalanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer__p_o_balance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_po_id')->constrained('customer_pos_management')->nullable()->onDelete('cascade');
            $table->float('previous_po_balance',16,2)->nullable();
            $table->float('new_po_balance',16,2)->nullable();
            $table->float('invoice_amount',16,2)->nullable();
            $table->foreignId('customer_invoice_id')->constrained('customer_invoice_managements')->nullable()->onDelete('cascade');

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
        Schema::dropIfExists('customer__p_o_balance_logs');
    }
}
