<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestorLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investor_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade')->after('customer_id');
            $table->foreignId('investor_id')->nullable()->constrained('investors')->onDelete('cascade');
            $table->string('investment_type')->nullable(); ##investor in/out
            $table->float('amount_ingoing_outgoing',16,4)->nullable();
            $table->float('investor_balance',16,4)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('investor_ledgers');
    }
}
