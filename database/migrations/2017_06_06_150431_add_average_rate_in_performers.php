<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAverageRateInPerformers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('performers', function (Blueprint $table) {
            $table->double('average_rate', 15, 2)->default(0)->after('email');

            $table->dropColumn('total_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('performers', function (Blueprint $table) {
            $table->dropColumn('average_rate');

            $table->integer('total_rate')->nullable()->after('email');
        });
    }
}
