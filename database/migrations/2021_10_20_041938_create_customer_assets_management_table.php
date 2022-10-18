<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAssetsManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_assets_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('asset_item_id')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('date_of_handover');
            $table->string('item_condition');
            // $table->string('asset_incharge')->nullable();
            $table->foreignId('asset_incharge_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('asset_brand');
            $table->string('model');
            $table->string('registration_number');
            $table->string('engine_name');
            $table->string('chassis_number');
            $table->string('color');
            $table->string('engine_capacity');
            $table->string('milage');
            $table->string('asset_Location');
            $table->decimal('market_price',16,2);
            $table->longText('specifications_1')->nullable();
            $table->longText('specifications_2')->nullable();
            $table->longText('description_input')->nullable();
            $table->json('document_file')->nullable();
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
        Schema::dropIfExists('customer_assets_management');
    }
}
