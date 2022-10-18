<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncrementManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('increment_management', function (Blueprint $table) {
            $table->id();
            $table->string('employee_cnic');
            $table->string('emp_name');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('father_name')->nullable();
            $table->string('joining_date')->nullable();

            $table->float('current_basic_salary',16,2)->nullable();
            $table->float('current_medical_allowance',16,2)->nullable();
            $table->float('current_mobile_allowance',16,2)->nullable();
            $table->float('current_laptop_bonus',16,2)->nullable();
            $table->float('current_conveyance_allowance',16,2)->nullable();
            $table->float('current_other_allowance',16,2)->nullable();


            $table->float('new_basic_salary',16,2)->nullable();
            $table->float('new_medical_allowance',16,2)->nullable();
            $table->float('new_mobile_allowance',16,2)->nullable();
            $table->float('new_laptop_bonus',16,2)->nullable();
            $table->float('new_conveyance_Allowance',16,2)->nullable();
            $table->float('new_other_allowance',16,2)->nullable();


            $table->float('inc_basic_salary',16,2)->nullable();
            $table->float('inc_medical_allowance',16,2)->nullable();
            $table->float('inc_mobile_allowance',16,2)->nullable();
            $table->float('inc_laptop_bonus',16,2)->nullable();
            $table->float('inc_conveyance_Allowance',16,2)->nullable();
            $table->float('inc_other_allowance',16,2)->nullable();

            
            $table->float('total_increment',16,2)->nullable();

            $table->longText('comments')->nullable();



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
        Schema::dropIfExists('increment_management');
    }
}
