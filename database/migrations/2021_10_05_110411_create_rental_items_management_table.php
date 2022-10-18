<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalItemsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_items_management', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('rental_id')->unique();
            $table->string('rental_name');
            $table->date('date_of_agreement')->nullable();
            $table->double('monthly_rental_amount',16,2)->nullable();
            $table->string('item_condition')->nullable();
            $table->string('brand')->nullable();
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');
            $table->string('model')->nullable();
            $table->string('engine_name')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('color')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->string('current_milage')->nullable();
            $table->string('current_localtion')->nullable();
            $table->longText('specifications_1')->nullable();
            $table->longText('specifications_2')->nullable();
            $table->longText('description_input')->nullable();
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('rental_items_management');
    }
}
