<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProjectIncomeInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_project_income_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade')->after('customer_id');
            $table->foreignId('invoice_id')->nullable()->constrained('customer_invoice_managements')->onDelete('cascade');
            $table->float('invoice_amount',16,4)->nullable();
            $table->float('pending_balance',16,4)->nullable();
            $table->string('status');
            // project income foreign key is missing
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
        Schema::dropIfExists('customer_project_income_invoices');
    }
}
