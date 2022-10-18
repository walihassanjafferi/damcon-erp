<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImprovedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('improved_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id')->nullable();            
            $table->string('module_name')->nullable();
            $table->string('category_name')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('main_id')->nullable();
            $table->integer('sub_id')->nullable();
            $table->integer('sub_sub_id')->nullable();
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
        Schema::dropIfExists('improved_categories');
    }
}
