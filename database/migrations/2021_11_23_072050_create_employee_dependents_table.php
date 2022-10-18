<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_dependents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');

            $table->string('name_one')->nullable();
            $table->date('dob_one')->nullable();
            $table->string('relationship_one')->nullable();
            $table->string('contact_no_one')->nullable();

            $table->string('name_two')->nullable();
            $table->date('dob_two')->nullable();
            $table->string('relationship_two')->nullable();
            $table->string('contact_no_two')->nullable();

            $table->string('name_three')->nullable();
            $table->date('dob_three')->nullable();
            $table->string('relationship_three')->nullable();
            $table->string('contact_no_three')->nullable();

            $table->string('name_four')->nullable();
            $table->date('dob_four')->nullable();
            $table->string('relationship_four')->nullable();
            $table->string('contact_no_four')->nullable();

            $table->string('name_five')->nullable();
            $table->date('dob_five')->nullable();
            $table->string('relationship_five')->nullable();
            $table->string('contact_no_five')->nullable();

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
        Schema::dropIfExists('employee_dependents');
    }
}
