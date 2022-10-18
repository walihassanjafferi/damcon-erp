<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->foreignId('investor_id')->constrained('investors')->onDelete('cascade');
            $table->string('payment_type');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->nullable();
            $table->foreignId('bank_id')->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_title');
            $table->string('cheque_number');
            $table->date('date');
            $table->decimal('amount',16,2);
            $table->string('payment')->nullable();
            $table->string('payment_details')->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('loan_payments');
    }
}
