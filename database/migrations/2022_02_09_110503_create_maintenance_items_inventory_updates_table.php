<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceItemsInventoryUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_items_inventory_updates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('maintenance_item_id')->nullable()
            ->constrained('mainterance_items_inventories')->onDelete('cascade');
            $table->date('date_of_update')->nullable();
            $table->string('stock_update')->nullable();
            $table->double('opening_stock')->nullable();
            $table->double('opening_stock_cost')->nullable();
            $table->string('quantity_type')->nullable();
            $table->double('updated_stock')->nullable();
            $table->double('updated_stock_cost')->nullable();
            $table->double('avg_stock_unit_cost')->nullable();
            $table->double('current_closing_stock')->nullable();
            $table->double('current_closing_stock_cost')->nullable();

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
        Schema::dropIfExists('maintenance_items_inventory_updates');
    }
}
