<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('performer_id')->nullable();
            $table->unsignedInteger('gallery_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('performer_id')
                  ->references('id')->on('performers')
                  ->onDelete('set null');
            $table->foreign('gallery_id')
                  ->references('id')->on('galleries')
                  ->onDelete('set null');
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('updated_by')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('performer_galleries');
    }
}
