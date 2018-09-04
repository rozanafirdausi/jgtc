<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMenuStatusStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dynamic_menus', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('dynamic_menus', function (Blueprint $table) {
            $table->string('status', 32)->after('url');
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
            $table->dropColumn('status');
        });

        Schema::table('dynamic_menus', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->after('url');
        });
    }
}
