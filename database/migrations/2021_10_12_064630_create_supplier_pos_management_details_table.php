<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPosManagementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_pos_management_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_pos_id')->constrained('supplier_pos_management')->onDelete('cascade');
            $table->foreignId('inventory_item_id')
            ->constrained('project_items_inventories')->nullable()->onDelete('cascade');
            $table->string('item')->nullable();
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
        Schema::dropIfExists('supplier_pos_management_details');
    }
}
