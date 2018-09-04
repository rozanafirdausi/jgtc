<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShipmentAreaCodeInKabkotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kabkotas', function (Blueprint $table) {
            $table->string('shipment_area_code', 16)->after('code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kabkotas', function (Blueprint $table) {
            $table->dropColumn('shipment_area_code');
        });
    }
}
