<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPosManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_pos_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('customer_po_number');
            $table->double('amount_without_tax',32,2);
            $table->double('amount_with_tax',32,2);
            $table->date('customer_po_issue_date');
            $table->date('customer_po_start_date');
            $table->date('customer_po_end_date');
            $table->double('customer_po_balance',32,2);
            $table->boolean('status')->default(1);
            $table->longText('details_input')->nullable();
            $table->string('document_file')->nullable();
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
        Schema::dropIfExists('customer_pos_management');
    }
}
