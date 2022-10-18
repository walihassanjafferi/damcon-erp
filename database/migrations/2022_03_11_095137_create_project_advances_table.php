<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_advances', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')
            ->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('module_name')->nullable();
            $table->integer('module_id')->nullable();
            $table->string('payment_title')->nullable();
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
        Schema::dropIfExists('project_advances');
    }
}
