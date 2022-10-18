<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainteranceItemsConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mainterance_items_consumptions', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_issuance');
            $table->string('title')->nullable();
            $table->foreignId('project_id')
            ->nullable()
            ->constrained('projects')
            ->onDelete('cascade');
            $table->foreignId('damcon_assset_id')
            ->nullable()
            ->constrained('damcon_asssets')
            ->onDelete('cascade');
            $table->string('current_possession')->nullable();
            $table->float('issued_items_cost',16,4);
            $table->foreignId('issued_person_id')->constrained('employeemanagements')->onDelete('cascade');

            $table->string('milage_hours')->nullable();
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('mainterance_items_consumptions');
    }
}
