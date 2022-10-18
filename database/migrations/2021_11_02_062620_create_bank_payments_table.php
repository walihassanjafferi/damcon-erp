<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('expense_type');
            $table->string('payment_type');
            $table->foreignId('bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('batch_payments_management')->onDelete('cascade');
            $table->string('cheque_number')->nullable();
            $table->date('payment_date');
            $table->string('region')->nullable();
            $table->decimal('amount',16,2)->nullable();
            $table->string('paid_to_person')->nullable();
            $table->longText('comments');
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
        Schema::dropIfExists('bank_payments');
    }
}
