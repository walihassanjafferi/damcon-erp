<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchManagementLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_management_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->nullable()->constrained('batches_management')->onDelete('cascade');
            $table->string('invoice_type')->nullable();
            $table->integer('invoice_id')->nullable();
            $table->string('batch_status')->nullable();
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
        Schema::dropIfExists('batch_management_logs');
    }
}
