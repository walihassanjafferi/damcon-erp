<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamconAssetDepreciationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damcon_asset_depreciations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('asset_id')->constrained('damcon_asssets')->onDelete('cascade');
            $table->date('date_of_purchase');
            $table->string('asset_brand');
            $table->string('model');
            $table->string('registration_number');
            $table->string('engine_name');
            $table->string('chassis_number');
            $table->string('color');
            $table->string('engine_capacity');
            $table->string('milage');
            $table->string('current_milage_hours');
            $table->decimal('purchase_price');
            $table->decimal('asset_new_price');
            $table->date('date_of_depreciation');
            $table->decimal('asset_last_price')->nullable();
            $table->date('last_date_of_depreciation')->nullable();
            $table->longText('specifications_1')->nullable();
            $table->longText('specifications_2')->nullable();
            $table->longText('description_input')->nullable();
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
        Schema::dropIfExists('damcon_asset_depreciations');
    }
}
