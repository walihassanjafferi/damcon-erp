<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToDamconAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('damcon_asssets', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->after('supplier_id')->constrained('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('damcon_asssets', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });
    }
}
