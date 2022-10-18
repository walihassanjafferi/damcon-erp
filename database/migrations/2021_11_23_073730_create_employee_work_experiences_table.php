<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeWorkExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_work_experiences', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');
            
            $table->string('jobtitle_one')->nullable();
            $table->string('organization_one')->nullable();
            $table->string('duration_one')->nullable();

            $table->string('jobtitle_two')->nullable();
            $table->string('organization_two')->nullable();
            $table->string('duration_two')->nullable();

            $table->string('jobtitle_three')->nullable();
            $table->string('organization_three')->nullable();
            $table->string('duration_three')->nullable();

            $table->string('jobtitle_four')->nullable();
            $table->string('organization_four')->nullable();
            $table->string('duration_four')->nullable();


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
        Schema::dropIfExists('employee_work_experiences');
    }
}
