<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectItemsInventoryProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('project_items_inventory_projects', function (Blueprint $table) {
            
            $table->foreignId('project_items_id')
            ->constrained('project_items_inventories')->onDelete('cascade');

            $table->foreignId('project_id')
            ->constrained('projects')
            ->onDelete('cascade');
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
