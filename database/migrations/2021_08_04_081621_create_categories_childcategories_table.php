<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesChildcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_childcategories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('chidcategories_id');

         //FOREIGN KEY CONSTRAINTS
           $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
           $table->foreign('chidcategories_id')->references('id')->on('chidcategories')->onDelete('cascade');

         //SETTING THE PRIMARY KEYS
          // $table->primary(['user_id','role_id']);
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
        Schema::dropIfExists('categories_childcategories');
    }
}
