<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerformerCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performer_candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 64);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('avatar')->nullable();
            $table->integer('position_order')->default(0);
            $table->integer('total_vote')->nullable();
            $table->tinyInteger('is_visible')->default(1);
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
        Schema::dropIfExists('performer_candidates');
    }
}
