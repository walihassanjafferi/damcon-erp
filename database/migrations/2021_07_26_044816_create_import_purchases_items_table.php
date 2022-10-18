<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportPurchasesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_purchases_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('import_purchases_id');
            $table->foreign('import_purchases_id')->references('id')->on('import_purchases')->onDelete('cascade');
            $table->longText('item_name');
            $table->integer('item_qunatity');
            $table->string('item_cost');
            $table->double('sub_total')->nullable();
            $table->double('tax_amount')->nullable();
            $table->double('total_amount')->nullable();
            $table->double('sales_tax_wh_src')->nullable();
            $table->double('supplier_wh_tax1')->nullable();
            $table->double('damcon_gain')->nullable();
            $table->double('supplier_gain')->nullable();



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
        Schema::dropIfExists('import_purchases_items');
    }
}
