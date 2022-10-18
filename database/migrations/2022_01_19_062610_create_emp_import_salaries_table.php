<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpImportSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_import_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('employee_code')->nullable(); //2
            $table->string('name')->nullable(); //3
            $table->boolean('salary_status')->nullable(); //4
            $table->date('joining_date')->nullable(); //5
            $table->string('cnic')->nullable(); //6
            $table->string('salary_account_type')->nullable(); //7
            $table->string('salaray_receiving_emp_name')->nullable(); //8
            $table->string('salaray_receiving_emp_id')->nullable(); //9
            $table->string('salaray_receiving_emp_bank_id')->nullable(); //10   
            $table->string('self_bank_account_details')->nullable(); //11
            $table->string('emp_email')->nullable(); //12
            $table->boolean('send_salary_slip_check')->nullable(); //13
            $table->string('desgination')->nullable(); //14
            $table->string('project_id')->nullable(); //15
            $table->string('project')->nullable(); //16
            $table->string('region')->nullable(); //17
            $table->string('location')->nullable(); //18
            $table->string('income_tax')->nullable(); //19
            $table->text('final_adjustments')->nullable(); //21
            $table->float('basic_salary',16,2)->nullable(); //22
            $table->float('medical_allowance',16,2)->nullable(); //23
            $table->float('mobile_allowance',16,2)->nullable(); //24
            $table->float('laptop_bonus',16,2)->nullable(); //25
            $table->float('conveyance_Allowance',16,2)->nullable(); //26
            $table->float('other_allowance',16,2)->nullable(); //27
            $table->string('over_time')->nullable(); //28
            $table->string('over_time_comments')->nullable(); //29
            $table->string('kpi_other_bonus')->nullable(); //30
            $table->string('kpi_other_bonus_comments')->nullable(); //31
            $table->string('eda_allowance')->nullable(); //32
            $table->string('eda_allowance_comments')->nullable(); //33
            $table->string('tada_allowance')->nullable(); //34
            $table->string('tada_allowance_comments')->nullable(); //35
            $table->string('advanced_salary_id')->nullable(); //36
            $table->string('advanced_salary')->nullable(); //37
            $table->text('advanced_salary_comments')->nullable(); //38
            $table->string('final_settlement_termination')->nullable(); //39
            $table->string('final_settlement_termination_comments')->nullable(); //40
            $table->string('miscellaneous_payment')->nullable(); //41
            $table->text('miscellaneous_payment_comments')->nullable(); //42
            $table->string('gross_payment')->nullable(); //43
            $table->string('health_life_insurance_deduction')->nullable(); //44
            $table->string('eobi_deduction')->nullable(); //45
            $table->string('absent_deduction')->nullable(); //46
            $table->text('absent_deduction_comments')->nullable(); //47
            $table->string('advanced_salary_deduction')->nullable(); //48
            $table->text('advanced_salary_deduction_comments')->nullable(); //49
            $table->string('kpi_deduction')->nullable(); //50
            $table->text('kpi_deduction_comments')->nullable(); //51
            $table->string('late_coming_deduction')->nullable(); //52
            $table->text('late_coming_deduction_comments')->nullable(); //53
            $table->string('miscellaneous_deduction')->nullable(); //54
            $table->text('miscellaneous_deduction_comments')->nullable(); //55
            $table->string('total_deduction')->nullable(); //56
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
        Schema::dropIfExists('emp_import_salaries');
    }
}
