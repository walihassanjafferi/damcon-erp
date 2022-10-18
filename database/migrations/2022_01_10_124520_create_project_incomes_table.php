<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade')->after('customer_id');
            $table->date('cheque_receving_date')->nullable();
            $table->string('received_cheque_bank')->nullable();
            $table->date('cheque_clearing_date')->nullable();
            $table->string('cheque_number')->nullable();
            $table->float('cheque_amount',16,4)->nullable();
            $table->foreignId('cash_deposit_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->longText('difference_comments')->nullable();
            $table->float('bad_debt_amount',16,4)->nullable();
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
        Schema::dropIfExists('project_incomes');
    }
}
