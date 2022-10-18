<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->foreignId('leaves_management_id')->constrained('leaves_management')->onDelete('cascade')->nullable();
            $table->string('leave_type')->nullable();
            $table->integer('no_of_leave_days');
            $table->date('leave_date');
            $table->integer('no_of_leaves_left');
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
        Schema::dropIfExists('leaves_records');
    }
}
