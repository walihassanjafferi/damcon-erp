<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesubordinatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeesubordinates', function (Blueprint $table) {
            $table->id();

            $table->integer('subordinate_id');
            $table->integer('employee_id');

            // $table->unsignedBigInteger('employeemanagement_id');
            // $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements');

            // $table->unsignedBigInteger('employeemanagement_id');
            // $table->foreign('subordinate_id')->references('id')->on('employeemanagements');

            // $table->foreign('employeemanagement_id','subordinate_id')->references('id')->on('employeemanagements')->onDelete('cascade');
            // $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');
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
        Schema::dropIfExists('employeesubordinates');
    }
}
