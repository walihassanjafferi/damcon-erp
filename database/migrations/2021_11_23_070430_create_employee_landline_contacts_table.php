<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLandlineContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_landline_contacts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');

            $table->string('name_one')->nullable();
            $table->string('relationship_one')->nullable();
            $table->string('verification_status_one')->nullable();
            $table->string('contact_no_one')->nullable();

            $table->string('name_two')->nullable();
            $table->string('relationship_two')->nullable();
            $table->string('verification_status_two')->nullable();
            $table->string('contact_no_two')->nullable();

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
        Schema::dropIfExists('employee_landline_contacts');
    }
}
