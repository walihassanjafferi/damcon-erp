<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_references', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');

            $table->string('reference_name_one')->nullable();
            $table->string('reference_contactno_one')->nullable();
            $table->string('reference_occupation_one')->nullable();
            $table->string('reference_email_one')->nullable();

            $table->string('reference_name_two')->nullable();
            $table->string('reference_contactno_two')->nullable();
            $table->string('reference_occupation_two')->nullable();
            $table->string('reference_email_two')->nullable();
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
        Schema::dropIfExists('employee_references');
    }
}
