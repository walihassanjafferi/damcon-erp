<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalPOItemsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_p_o_items_management', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_pos_id')->constrained('rental_purchase_orders_management')->onDelete('cascade');
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
        Schema::dropIfExists('rental_p_o_items_management');
    }
}
