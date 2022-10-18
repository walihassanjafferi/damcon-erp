<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterProjectTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inter_project_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('cnic');
            $table->string('emp_name');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('father_name')->nullable();
            $table->string('joining_date')->nullable();
            $table->float('basic_salary',16,2)->nullable();
            $table->string('region')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('current_project_id')->constrained('projects')->onDelete('cascade')->nullable();
            $table->foreignId('new_project_id')->constrained('projects')->onDelete('cascade')->nullable();
            $table->date('date_of_transfer');
            $table->longText('reason_of_transfer')->nullable();
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
        Schema::dropIfExists('inter_project_transfers');
    }
}
