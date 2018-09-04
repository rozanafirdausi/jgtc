<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('template');
            $table->string('subject')->nullable();
            $table->string('action_button_text')->nullable();
            $table->longText('before_action_button')->nullable();
            $table->longText('after_action_button')->nullable();
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
        Schema::drop('email_settings');
    }
}
