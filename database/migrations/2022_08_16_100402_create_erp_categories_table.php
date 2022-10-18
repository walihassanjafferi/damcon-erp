<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateErpCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erp_categories', function (Blueprint $table) {
            $table->id();
            $table->string('module_id')->nullable();
            $table->string('module_name')->nullable();
            $table->string('category_name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('main_id')->nullable();
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
        Schema::dropIfExists('erp_categories');
    }
}
