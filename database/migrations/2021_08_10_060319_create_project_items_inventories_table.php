<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectItemsInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_items_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('item_name');
            // $table->foreignId('category_id')
            // ->nullable()
            // ->constrained('categories')
            // ->onDelete('cascade');
            // $table->foreignId('chidcategories_id')
            // ->nullable()
            // ->constrained('chidcategories')
            // ->onDelete('cascade');

            $table->foreignId('cat_parent_id')
            ->nullable()
            ->constrained('improved_categories')
            ->onDelete('cascade');
            $table->foreignId('cat_main_id')
            ->nullable()
            ->constrained('improved_categories')
            ->onDelete('cascade');
            $table->foreignId('cat_sub_id')
            ->nullable()
            ->constrained('improved_categories')
            ->onDelete('cascade');
            $table->foreignId('cat_sub_sub_id')
            ->nullable()
            ->constrained('improved_categories')
            ->onDelete('cascade');

            $table->string('current_balance_item');
            $table->string('current_stock_cost');
            $table->string('item_brand')->nullable();
            $table->string('unit_of_measure')->nullable();
            $table->date('date_of_addition')->nullable();
            $table->longText('description');
            $table->longText('technical_specification_1')->nullable();
            $table->longText('technical_specifications_2')->nullable();
            $table->longText('comments');
            $table->double('average_unit_cost')->nullable();

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
        Schema::dropIfExists('project_items_inventories');
    }
}
