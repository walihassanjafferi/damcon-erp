<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeemanagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeemanagements', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('father_name')->nullable();
            $table->string('cnic')->nullable();
            $table->string('employee_damcon_id');
            $table->string('eobi_member_checkbox')->nullable();
            $table->string('eobi_number')->nullable();
            $table->string('social_security_member_checkbox')->nullable();
            $table->string('social_security_number')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')
            ->onDelete('cascade');
            $table->date('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->integer('line_manager_employee_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('contact_no_1')->nullable();
            $table->string('contact_no_2')->nullable();
            $table->string('email_address_1')->unique()->nullable();
            $table->string('email_address_2')->unique()->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('region')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('assigned_locations')->nullable();
            $table->string('form_step')->nullable();
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
        Schema::dropIfExists('employeemanagements');
    }
}
