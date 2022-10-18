<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExitManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_exit_management', function (Blueprint $table) {
            $table->id();   
            $table->string('title')->nullable();
            $table->string('employee_cnic');
            $table->string('emp_name');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('father_name')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->string('region')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->date('last_working_date')->nullable();
            $table->json('assigned_assets')->nullable();
            $table->json('advancehr')->nullable();
            $table->json('projectadvances')->nullable();
            $table->longText('notice_period')->nullable();
            $table->string('notice_period_days')->nullable();
            $table->string('short_days')->nullable();
            $table->string('settlement_month')->nullable();
            $table->longText('reason_of_termination')->nullable();
            $table->longText('final_settlement_offer')->nullable();
            $table->longText('final_settlement_comments')->nullable();
            $table->boolean('customer_project_manager_status')->nullable();
            $table->longText('customer_project_manager_comments')->nullable();
            $table->boolean('damcon_director_status')->nullable();
            $table->longText('damcon_director_comments')->nullable();
            $table->boolean('procurement_manager_status')->nullable();
            $table->longText('procurement_manager_comments')->nullable();
            $table->boolean('assets_manager_status')->nullable();
            $table->longText('assets_manager_comments')->nullable();
            $table->boolean('finance_manager_status')->nullable();
            $table->longText('finanace_manager_comments')->nullable();
            $table->boolean('hr_manager_status')->nullable();
            $table->longText('hr_manager_comments')->nullable();
            $table->json('document_file')->nullable();

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
        Schema::dropIfExists('employee_exit_management');
    }
}
