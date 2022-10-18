<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxationBodiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxation_bodies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('sales_tax_percentage_items');
            $table->string('sales_tax_percentage_services');
            $table->string('withholding_items')->nullable();
            $table->string('withholding_services')->nullable();
            $table->longText('comments_about_law');
            $table->string('sales_tax_withheld_source_percentage')->nullable();
            $table->date('rule_creation_date');
            $table->date('rule_modification_date')->nullable();
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
        Schema::dropIfExists('taxation_bodies');
    }
}
