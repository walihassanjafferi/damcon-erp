<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->string('employee_cnic');
            $table->string('emp_name');
            $table->string('father_name')->nullable();
            $table->date('joining_date')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('no_off_Days')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('leaves_management');
    }
}
