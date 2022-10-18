<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectorwithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('directorwithdraws', function (Blueprint $table) {
            $table->id();
            $table->string('partner_name');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('debited_bank_id')->nullable()->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_number')->nullable();
            $table->date('cheque_clearing_date')->nullable();
            $table->string('cheque_title')->nullable();
            $table->float('amount',16,4)->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('directorwithdraws');
    }
}
