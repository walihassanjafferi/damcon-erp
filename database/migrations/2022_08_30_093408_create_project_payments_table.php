<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_payments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('erp_categories')->onDelete('cascade');
            $table->foreignId('main_category_id')->constrained('erp_categories')->onDelete('cascade');
            $table->foreignId('sub_category_id')->constrained('erp_categories')->onDelete('cascade');
            $table->string('paid_person')->nullable();
            $table->date('transaction_date')->nullable();
            $table->foreignId('bank_id')->references('id')->on('bankaccounts');
            $table->longText('comment')->nullable();
            $table->float('amount',16,2);
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
        Schema::dropIfExists('project_payments');
    }
}
