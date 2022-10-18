<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuel_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->enum('fuel_type_card',['pso_fuel_card','cash_purchased_fuel','customer_fuel']);
            $table->foreignId('project_id')
            ->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('supplier_id')
            ->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->string('person_name')->nullable();
            $table->string('current_balance_item')->nullable();
            $table->string('current_stock_cost')->nullable();
            $table->float('average_unit_cost',16,4)->nullable();
            $table->string('fuel_type');
            $table->string('fuel_card_no')->nullable();
            $table->date('date_of_addition');
            $table->string('monthly_limit')->nullable();
            $table->string('monthly_limit_rupees')->nullable();
            $table->date('card_issue_date');
            $table->date('card_expiry_date');
            $table->longText('comments');
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
        Schema::dropIfExists('fuel_items');
    }
}
