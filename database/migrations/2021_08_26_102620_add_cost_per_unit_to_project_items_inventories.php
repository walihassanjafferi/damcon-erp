<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostPerUnitToProjectItemsInventories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_items_inventories', function (Blueprint $table) {
            $table->float('cost_per_unit',16,4)->nullable()->after('current_stock_cost');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_items_inventories', function (Blueprint $table) {
            //
        });
    }
}
