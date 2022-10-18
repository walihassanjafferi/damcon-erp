<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchPaymentsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_payments_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->foreignId('batch_id')->constrained('batches_management')->onDelete('cascade');
            $table->foreignId('bank_of_batch')->constrained('bankaccounts')->onDelete('cascade');
            $table->date('date_of_cheque');
            $table->decimal('amount',32,2);
            $table->string('cheque_title');
            $table->string('cheque_number');
            $table->longText('batch_description')->nullable();
            $table->longText('comment_box')->nullable();
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
        Schema::dropIfExists('batch_payments_management');
    }
}
