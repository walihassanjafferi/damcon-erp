<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSecurityPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('security_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('payment_method');
            $table->foreignId('bank_id')->constrained('bankaccounts')->onDelete('cascade')->nullable();
            $table->foreignId('batch_id')->nullable()->constrained('batch_payments_management')->onDelete('cascade');
            $table->foreignId('payment_type')->constrained('categories')->onDelete('cascade');
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('date');
            $table->decimal('amount',16,2);
            $table->string('payment_details')->nullable();
            $table->string('customer')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
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
        Schema::dropIfExists('security_payments');
    }
}
