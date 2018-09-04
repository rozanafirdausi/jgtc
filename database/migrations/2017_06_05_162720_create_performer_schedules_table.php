<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('performer_id')->nullable();
            $table->unsignedInteger('schedule_id')->nullable();
            $table->timestamps();

            $table->foreign('performer_id')
                  ->references('id')->on('performers')
                  ->onDelete('set null');
            $table->foreign('schedule_id')
                  ->references('id')->on('schedules')
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
        Schema::dropIfExists('performer_schedules');
    }
}
