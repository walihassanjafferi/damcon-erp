<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceHrPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_hr_payments', function (Blueprint $table) {
            $table->id();
            $table->string('advance_hr_title')->nullable();
            $table->string('employee_cnic');
            $table->string('emp_name');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('father_name')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->string('region')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->float('amount',16,4);
            $table->longText('comments');
            $table->foreignId('payment_id')->nullable();
            $table->string('advance_type');
            $table->string('payment_mode');
            $table->string('bank_account')->nullable();
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('date');
            $table->longText('description')->nullable();
            $table->json('document_file')->nullable();
            $table->string('payment_type')->nullable();
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
        Schema::dropIfExists('advance_hr_payments');
    }
}
