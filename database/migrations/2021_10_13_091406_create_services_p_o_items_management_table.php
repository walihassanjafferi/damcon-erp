<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesPOItemsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_p_o_items_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('services_pos_id')->constrained('services_purchase_orders_management')->onDelete('cascade');
            $table->foreignId('maintenance_item_id')
            ->constrained('mainterance_items_inventories')->nullable()->onDelete('cascade');
            $table->string('item');
            $table->bigInteger('qty');
            $table->decimal('cost',8,2);
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
        Schema::dropIfExists('services_p_o_items_management');
    }
}
