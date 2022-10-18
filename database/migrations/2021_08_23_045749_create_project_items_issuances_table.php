<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectItemsIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_items_issuances', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_issuance');
            $table->string('title');
            $table->foreignId('project_id')
            ->nullable()
            ->constrained('projects')
            ->onDelete('cascade');
            $table->string('region');
            $table->float('issued_items_cost',16,4);
            $table->foreignId('issued_person_id')->constrained('employeemanagements')->onDelete('cascade');
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
        Schema::dropIfExists('project_items_issuances');
    }
}
