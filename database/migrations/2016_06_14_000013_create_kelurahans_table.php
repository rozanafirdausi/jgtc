<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKelurahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kecamatan_id')->unsigned();
            $table->string('code', 32);
            $table->string('name', 128);
            $table->timestamps();

            //Constraints
            $table->foreign('kecamatan_id')
                ->references('id')->on('kecamatans')
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
        Schema::table('kelurahans', function (Blueprint $table) {
            //Drop Constraint
            $table->dropForeign('kelurahans_kecamatan_id_foreign');
        });
        //Drop Table
        Schema::drop('kelurahans');
    }
}
