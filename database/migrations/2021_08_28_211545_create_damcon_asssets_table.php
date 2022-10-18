<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDamconAsssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('damcon_asssets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_item_id')->unique();
            $table->foreignId('supplier_id')
            ->nullable()
            ->constrained('suppliers')
            ->onDelete('cascade');
            $table->date('date_of_purchase')->nullable();
            $table->string('item_condition')->nullable();
            // $table->string('asset_incharge')->nullable();
            $table->foreignId('asset_incharge_id')->constrained('employeemanagements')->onDelete('cascade')->nullable();
            $table->string('mode_of_purchase');
            $table->string('mode_of_payment');
            $table->longText('description')->nullable();
            $table->string('asset_brand')->nullable();
            $table->string('model')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('chasssis_no')->nullable();
            $table->string('color')->nullable();
            $table->string('engine_capacity')->nullable();
            $table->longText('technical_specification_1')->nullable();
            $table->longText('technical_specifications_2')->nullable();
            $table->float('purchase_price',16,4);
            $table->string('asset_maintenance_type')->nullable();
            $table->string('asset_maintenance_duration')->nullable();
            $table->string('milage_hours')->nullable();
            $table->string('asset_location')->nullable();
            $table->longText('comments');
            $table->string('file_attachments')->nullable();
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
        Schema::dropIfExists('damcon_asssets');
    }
}
