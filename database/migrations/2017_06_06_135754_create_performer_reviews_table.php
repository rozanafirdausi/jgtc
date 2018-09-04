<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('performer_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('rate')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')->on('performer_reviews')
                  ->onDelete('set null');
            $table->foreign('performer_id')
                  ->references('id')->on('performers')
                  ->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('performer_reviews');
    }
}
