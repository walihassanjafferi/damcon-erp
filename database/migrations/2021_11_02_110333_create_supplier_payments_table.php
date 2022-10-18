<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('po_id')->constrained('supplier_pos_management')->nullable()->onDelete('cascade');
            $table->foreignId('supplier_id')->constrained('suppliers')->nullable()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('supplier_type');
            $table->string('payment_method');
            $table->foreignId('bank_id')->constrained('bankaccounts')->onDelete('cascade')->nullable();
            $table->string('cheque_title')->nullable();
            $table->string('cheque_number')->nullable();
            $table->date('date');
            $table->decimal('amount',16,2)->nullable();
            $table->string('payment_details')->nullable();
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
        Schema::dropIfExists('supplier_payments');
    }
}
