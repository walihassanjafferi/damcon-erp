<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainteranceSubItemConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainterance_sub_item_consumptions', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('issuance_id')
            ->constrained('mainterance_items_consumptions')->onDelete('cascade');

            $table->foreignId('inventory_id')
            ->constrained('mainterance_items_inventories')->onDelete('cascade');


            
            $table->longText('item_name');
            $table->integer('item_quantity');
            $table->float('item_cost',16,4);


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
        Schema::dropIfExists('mainterance_sub_item_consumptions');
    }
}
