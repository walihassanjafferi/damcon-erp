<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPosManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_pos_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('purchase_od_number');
            $table->string('grm_number')->nullable();
            $table->string('type');
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('customer_optional_number')->nullable();
            $table->string('requesting_person')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('items_delivery_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('pr_number')->nullable();
            $table->string('tax_body_id');
            $table->string('taxation_month');
            $table->string('tax_body_percentage');
            $table->string('sales_tax_wh');
            $table->string('tax_deduction_1');
            $table->string('tax_deduction_2');
            $table->json('document_file')->nullable();
            
            $table->float('sub_total_amount',16,4)->nullable();
            $table->float('tax_amount',16,4)->nullable();
            $table->float('total_amount',16,4)->nullable();
            $table->float('sales_tax_wh_at_src',16,4)->nullable();
            $table->float('supplier_wh_tax_1',16,4)->nullable();
            $table->float('supplier_wh_tax_2',16,4)->nullable();
            $table->float('total_after_deduction',16,4)->nullable();
            $table->float('after_tax_item_cost',16,4)->nullable();




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
        Schema::dropIfExists('supplier_pos_management');
    }
}
