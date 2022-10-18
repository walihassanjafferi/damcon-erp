<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesPurchaseOrdersManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_purchase_orders_management', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('title_po_number');
            $table->tinyInteger('type');
            $table->string('grm_number')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('requesting_person')->nullable();
            $table->string('customer_po_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->date('isseu_date')->nullable();
            $table->string('pr_number')->nullable();
            $table->foreignId('tax_body_id')->constrained('taxation_bodies')->onDelete('cascade');
            $table->string('tax_body_percentage');
            $table->string('taxation_month');
            $table->string('sales_tax_wh');
            $table->string('supplier_tax_deduction_1');
            $table->string('supplier_tax_deduction_2');

            $table->float('sub_total_amount',16,4)->nullable();
            $table->float('tax_amount',16,4)->nullable();
            $table->float('total_amount',16,4)->nullable();
            $table->float('sales_tax_wh_at_src',16,4)->nullable();
            $table->float('supplier_wh_tax_1',16,4)->nullable();
            $table->float('supplier_wh_tax_2',16,4)->nullable();
            $table->float('total_after_deduction',16,4)->nullable();
            
            $table->json('document_file')->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('services_purchase_orders_management');
    }
}
