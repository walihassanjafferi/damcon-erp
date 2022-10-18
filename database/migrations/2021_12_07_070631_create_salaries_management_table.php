<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('payment_id');
            $table->string('salary_month');
            $table->string('no_of_days');
            $table->string('payment_method');
            $table->foreignId('debited_bank_id')->constrained('bankaccounts')->onDelete('cascade')->nullable();
            $table->string('cheque_number')->nullable();
            $table->string('cheque_title')->nullable();
            $table->date('date');
            $table->float('amount',16,2);
            $table->longText('payment_details')->nullable();
            $table->boolean('batch_added')->default(0)->nullable();
            $table->boolean('batch_status')->default(0)->nullable();
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
        Schema::dropIfExists('salaries_management');
    }
}
