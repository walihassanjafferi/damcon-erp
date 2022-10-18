<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamconAssetSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damcon_asset_sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreignId('asset_id')->constrained('damcon_asssets')->onDelete('cascade');
            $table->string('asset_brand');
            $table->string('model');
            $table->string('registration_number');
            $table->string('engine_name');
            $table->string('chassis_number');
            $table->string('color');
            $table->string('engine_capacity');
            $table->string('milage');
            $table->string('last_milage_hours');
            $table->decimal('purchase_price',32,2);
            $table->decimal('asset_last_price',32,2);
            $table->date('date_of_purchase');
            $table->foreignId('bank_id')->constrained('bankaccounts')->onDelete('cascade');
            $table->string('cheque_no');
            $table->decimal('sale_price',32,2);
            $table->longText('specifications_1')->nullable();
            $table->longText('specifications_2')->nullable();
            $table->longText('description_input')->nullable();
            $table->longText('sold_party_details')->nullable();
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
        Schema::dropIfExists('damcon_asset_sales');
    }
}
