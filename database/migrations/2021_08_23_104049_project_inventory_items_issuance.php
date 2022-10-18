<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectInventoryItemsIssuance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_inventory_items_issuance', function (Blueprint $table) {
            $table->id();
           

            // $table->unsignedBigInteger('project_items_issuance_id');
            // $table->foreign('project_items_issuance_id')->references('id')->on('project_items_issuances')->onDelete('cascade');

            // $table->unsignedBigInteger('project_items_inventory_id');
            // $table->foreign('project_items_inventory_id')->references('id')->on('project_items_inventories')->onDelete('cascade');
        
            $table->foreignId('issuance_id')
            ->constrained('project_items_issuances')->onDelete('cascade');

            $table->foreignId('inventory_id')
            ->constrained('project_items_inventories')->onDelete('cascade');


            
            $table->longText('item_name');
            $table->integer('item_qunatity');
            $table->string('item_cost');
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
        //
    }
}
