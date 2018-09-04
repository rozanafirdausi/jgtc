<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteReceiverIdToDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropForeign('discussions_receiver_1_id_foreign');
            $table->dropColumn('receiver_1_id');
            $table->dropForeign('discussions_receiver_2_id_foreign');
            $table->dropColumn('receiver_2_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
