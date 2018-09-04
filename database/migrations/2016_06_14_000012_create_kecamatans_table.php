<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKecamatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kecamatans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kabkota_id')->unsigned();
            $table->string('code', 32);
            $table->string('name', 128);
            $table->timestamps();

            //Constraints
            $table->foreign('kabkota_id')
                ->references('id')->on('kabkotas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kecamatans', function (Blueprint $table) {
            //Drop Constraint
            $table->dropForeign('kecamatans_kabkota_id_foreign');
        });
        //Drop Table
        Schema::drop('kecamatans');
    }
}
