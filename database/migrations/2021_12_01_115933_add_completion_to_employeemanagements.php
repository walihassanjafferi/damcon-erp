<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletionToEmployeemanagements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employeemanagements', function (Blueprint $table) {
            $table->boolean('completed_flag')->default(0)->nullable()->after('form_step');
            $table->json('forms_data_score')->nullable()->after('completed_flag');
            $table->json('document_file')->nullable()->after('forms_data_score');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employeemanagements', function (Blueprint $table) {
            //
        });
    }
}
