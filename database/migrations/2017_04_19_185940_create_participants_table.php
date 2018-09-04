<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 64);
            $table->string('name');
            $table->string('email', 64)->unique()->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->integer('position_order')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('city_id')
                  ->references('id')->on('kabkotas')
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
        Schema::dropIfExists('participants');
    }
}
