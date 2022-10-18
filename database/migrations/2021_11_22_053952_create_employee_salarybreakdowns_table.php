<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalarybreakdownsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salarybreakdowns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');
            $table->decimal('basic_salary',16,2)->nullable();
            $table->decimal('medical_allowance',16,2)->nullable();
            $table->decimal('mobile_allowance',16,2)->nullable();
            $table->decimal('laptop_bonus',16,2)->nullable();
            $table->decimal('conveyance_allowance',16,2)->nullable();
            $table->decimal('other_allowance',16,2)->nullable();
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
        Schema::dropIfExists('employee_salarybreakdowns');
    }
}
