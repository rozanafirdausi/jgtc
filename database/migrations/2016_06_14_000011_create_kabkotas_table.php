<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKabkotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kabkotas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->unsigned();
            $table->string('code', 32);
            $table->string('name', 128);
            $table->timestamps();

            //Constraints
            $table->foreign('province_id')
                ->references('id')->on('provinces')
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
        Schema::table('kabkotas', function (Blueprint $table) {
            //Drop Constraint
            $table->dropForeign('kabkotas_province_id_foreign');
        });
        //Drop Table
        Schema::drop('kabkotas');
    }
}
