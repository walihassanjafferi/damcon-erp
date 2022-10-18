<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsPOItemsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets_p_o_items_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assets_pos_id')->constrained('assets_purchase_orders_management')->onDelete('cascade');
            $table->string('item');
            $table->bigInteger('qty');
            $table->decimal('cost',16,2);
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
        Schema::dropIfExists('assets_p_o_items_management');
    }
}
