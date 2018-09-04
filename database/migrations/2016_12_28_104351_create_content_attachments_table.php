<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->unsigned()->nullable();
            $table->string('filename');
            $table->string('title');
            $table->text('description', 65535)->nullable();
            $table->integer('position_order')->default(0);
            $table->timestamps();

            $table->foreign('content_id')
                  ->references('id')->on('contents')
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
        Schema::dropIfExists('content_attachments');
    }
}
