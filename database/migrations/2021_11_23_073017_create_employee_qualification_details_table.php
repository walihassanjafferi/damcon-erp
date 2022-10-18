<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeQualificationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_qualification_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');

            $table->string('program_one')->nullable();
            $table->string('passing_year_one')->nullable();
            $table->string('marks_percentage_one')->nullable();

            $table->string('program_two')->nullable();
            $table->string('passing_year_two')->nullable();
            $table->string('marks_percentage_two')->nullable();

            $table->string('program_three')->nullable();
            $table->string('passing_year_three')->nullable();
            $table->string('marks_percentage_three')->nullable();

            $table->string('program_four')->nullable();
            $table->string('passing_year_four')->nullable();
            $table->string('marks_percentage_four')->nullable();

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
        Schema::dropIfExists('employee_qualification_details');
    }
}
