<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performer_1_id')->unsigned()->nullable();
            $table->integer('performer_2_id')->unsigned()->nullable();
            $table->integer('total_vote')->default(0);
            $table->foreign('performer_1_id')
                  ->references('id')->on('performer_candidates')
                  ->onDelete('set null');
            $table->foreign('performer_2_id')
                  ->references('id')->on('performer_candidates')
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
        Schema::dropIfExists('performer_groups');
    }
}
