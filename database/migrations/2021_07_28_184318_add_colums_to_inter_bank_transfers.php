<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumsToInterBankTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inter_bank_transfers', function (Blueprint $table) {
            //
            $table->float('sender_bank_current_balance',16,2)->nullable()->after('receiver_bank_id');
            $table->float('receiver_bank_current_balance',16,2)->nullable()->after('receiver_bank_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inter_bank_transfers', function (Blueprint $table) {
             $table->dropColumn('sender_bank_current_balance');
             $table->dropColumn('receiver_bank_current_balance');
        });
    }
}
