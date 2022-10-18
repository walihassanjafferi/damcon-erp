<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxBodyLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_body_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tax_body_id')->nullable()->constrained('Taxation_bodies')->onDelete('cascade');
            $table->string('transaction_type')->nullable();
            $table->string('module_name')->nullable();
            $table->integer('module_id')->nullable();
            $table->string('payment_title')->nullable();
            $table->float('amount',16,4)->nullable();
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
        Schema::dropIfExists('tax_body_ledgers');
    }
}
