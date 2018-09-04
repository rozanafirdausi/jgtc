<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDynamicMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('position'); // header, footer, middle, etc
            $table->integer('order');
            $table->string('label');
            $table->string('url');
            $table->enum('status', ['active', 'inactive']);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')->on('dynamic_menus')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dynamic_menus');
    }
}
