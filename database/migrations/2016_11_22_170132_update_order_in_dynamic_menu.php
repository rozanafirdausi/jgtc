<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderInDynamicMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamic_menus', function (Blueprint $table) {
            $table->integer('position_order')->after('order');
            $table->dropColumn('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dynamic_menus', function (Blueprint $table) {
            $table->integer('order')->after('position');
            $table->dropColumn('position_order');
        });
    }
}
