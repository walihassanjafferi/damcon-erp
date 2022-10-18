<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('suppliers_types_id');
            $table->foreign('suppliers_types_id')->references('id')->on('suppliers_types');
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('cp1_name')->nullable();
            $table->string('cp1_cell_no')->nullable();
            $table->string('cp1_phone_no')->nullable();
            $table->string('cp1_email')->nullable();
            $table->string('cp1_fax')->nullable();
            $table->string('cp2_name')->nullable();
            $table->string('cp2_cell_no')->nullable();
            $table->string('cp2_phone_no')->nullable();
            $table->string('cp2_email')->nullable();
            $table->string('cp2_fax')->nullable();
            $table->string('ntn_number')->nullable();
            $table->string('strn_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_title')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->date('date_of_creation')->nullable();
            $table->double('balance')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('suppliers');
    }
}
