<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePoliceVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_police_verifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employeemanagement_id');
            $table->foreign('employeemanagement_id')->references('id')->on('employeemanagements')->onDelete('cascade');

            $table->date('verification_date');
            $table->boolean('status')->default(1);
            $table->string('station')->nullable();


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
        Schema::dropIfExists('employee_police_verifications');
    }
}
