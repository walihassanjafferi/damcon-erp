<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityHealthSafetiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_health_safeties', function (Blueprint $table) {
            $table->id();
            $table->string('employee_cnic');
            $table->string('emp_name');
            $table->foreignId('employeemanagement_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('father_name')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('designation')->nullable();
            $table->string('region')->nullable();
            $table->string('location')->nullable();
            $table->date('event_date')->nullable();
            $table->foreignId('asset_id')->constrained('damcon_asssets')->onDelete('cascade')->nullable();
            $table->date('event_reporting_date')->nullable();
            $table->string('event_supervisor')->nullable();
            $table->longText('detailed_event_report')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('claim_category')->nullable();
            $table->longText('limit_details')->nullable();
            $table->longText('event_details')->nullable();
            $table->longText('claim_details')->nullable();
            $table->float('claim_amount',16,4)->nullable();
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('cheque_date')->nullable();
            $table->foreignId('bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('payment_type')->nullable();
            $table->boolean('status')->nullable();
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
        Schema::dropIfExists('quality_health_safeties');
    }
}
