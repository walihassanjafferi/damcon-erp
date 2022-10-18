<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_consumptions', function (Blueprint $table) {
            $table->id();
            $table->string('title_po_number');
            $table->foreignId('project_id')
            ->nullable()->constrained('projects')->onDelete('cascade');
            $table->date('date_of_entry')->nullable();
            $table->string('entry_person')->nullable();
            $table->string('driver_person')->nullable();
            $table->string('asset_type')->nullable();
            $table->integer('fueling_item_id');
            $table->integer('fuel_item_code');
            $table->foreignId('supplier_id')
            ->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->string('consumption_month');
            $table->float('quantity_in_liter',16,4)->nullable();
            $table->float('amount_with_sale_tax',16,4);
            $table->float('rate_fuel_per_liter',16,4);
            $table->string('milage_hours')->nullable();
            $table->string('oil_filter_due_date')->nullable();
            $table->string('item_type')->nullable();
            $table->string('per_km_fuel_consumption')->nullable();
            $table->string('per_km_fuel_cost')->nullable();


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
        Schema::dropIfExists('fuel_consumptions');
    }
}
