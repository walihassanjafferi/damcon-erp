<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiscIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misc_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('misc_date');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->string('income_type');
            $table->foreignId('advance_hr_payment_id')->nullable()->constrained('advance_hr_payments')->onDelete('cascade');
            $table->string('mode_of_payment');
            $table->date('cheque_receving_date')->nullable();
            $table->string('received_cheque_bank')->nullable();
            $table->date('cheque_clearing_date')->nullable();
            $table->string('cheque_number')->nullable();
            $table->float('cheque_amount',16,4)->nullable();
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('outward_payment_id')->nullable();
            $table->longText('misc_income_detail')->nullable();
            $table->longText('outward_payment_comments')->nullable();
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
        Schema::dropIfExists('misc_incomes');
    }
}
