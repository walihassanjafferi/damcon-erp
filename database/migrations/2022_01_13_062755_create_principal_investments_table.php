<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrincipalInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('principal_investments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('investor_id')->nullable()->constrained('investors')->onDelete('cascade');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->nullable();
            $table->float('current_balance_investor',16,4)->nullable();
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_number')->nullable();
            $table->date('cheque_clearing_date')->nullable();
            $table->float('cheque_amount',16,4)->nullable();
            $table->longText('payment_details')->nullable();
            $table->string('payment')->nullable();
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
        Schema::dropIfExists('principal_investments');
    }
}
