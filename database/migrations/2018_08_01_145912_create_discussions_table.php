<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->integer('sender_1_id')->unsigned()->nullable();
            $table->integer('sender_2_id')->unsigned()->nullable();
            $table->integer('receiver_1_id')->unsigned()->nullable();
            $table->integer('receiver_2_id')->unsigned()->nullable();
            $table->tinyInteger('is_read')->default(0);
            $table->foreign('sender_1_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('sender_2_id')
                  ->references('id')->on('participants')
                  ->onDelete('set null');
            $table->foreign('receiver_1_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('receiver_2_id')
                  ->references('id')->on('participants')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussions');
    }
}
