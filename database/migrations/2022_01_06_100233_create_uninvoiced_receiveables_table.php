<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUninvoicedReceiveablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uninvoiced_receiveables', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date')->nullable();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('month')->nullable();
            $table->string('region')->nullable();
            $table->longText('reason_of_uninvoicing')->nullable();
            $table->integer('estimated_qty')->nullable();
            $table->float('estimated_unit_price',16,4)->nullable();
            $table->float('sales_tax_percentage',16,4)->nullable();
            $table->foreignId('tax_id')->constrained('taxation_bodies')->onDelete('cascade');
            $table->longText('tax_type_comment')->nullable();
            $table->float('sales_tax_source_percentage',16,4)->nullable();
            $table->float('withhold_tax_percentage',16,4)->nullable();
            $table->longText('wh_type_comments')->nullable();
            $table->string('type_of_invoice')->nullable();
            $table->json('document_file')->nullable();
            // covert to invoice fields
            $table->string('invoice_number')->unique()->nullable();
            $table->foreignId('customer_po_id')->constrained('customer_pos_management')->onDelete('cascade')->nullable();
            $table->float('po_balance',16,4)->nullable();
            $table->string('customer_name')->nullable();
            $table->boolean('converted_to_invoice')->default(0)->nullable();
            $table->boolean('delete_uninvoice')->default(0);
            // covert to invoice fields

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
        Schema::dropIfExists('uninvoiced_receiveables');
    }
}
