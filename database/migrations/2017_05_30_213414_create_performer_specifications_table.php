<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerSpecificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_specifications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('performer_id');
            $table->string('type');
            $table->string('key');
            $table->string('value')->nullable();
            $table->text('description')->nullable();
            $table->integer('position_order')->default(0);
            $table->timestamps();

            $table->foreign('performer_id')
                  ->references('id')->on('performers')
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
        Schema::dropIfExists('performer_specifications');
    }
}
