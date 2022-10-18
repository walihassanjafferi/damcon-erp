<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFuelConsumptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_consumptions', function (Blueprint $table) {
            $table->foreignId('tax_body_id')->constrained('taxation_bodies')->onDelete('cascade');
            $table->string('taxation_month')->after('oil_filter_due_date');
            $table->string('tax_body_percentage')->after('oil_filter_due_date');
            $table->longText('comments')->after('oil_filter_due_date');
            $table->longText('file_attachments')->nullable()->after('oil_filter_due_date');
            $table->string('sales_tax_withheld_at_source_per')->after('oil_filter_due_date');
            $table->string('supplier_withheld_tax_1_deduction_per')->after('oil_filter_due_date'); 





        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_consumptions', function (Blueprint $table) {
            //
        });
    }
}
