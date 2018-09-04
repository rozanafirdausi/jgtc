<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentModules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('content_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();

            $table->foreign('parent_id')
                  ->references('id')->on('content_categories')
                  ->onDelete('set null');

            $table->foreign('type_id')
                  ->references('id')->on('content_types')
                  ->onDelete('restrict');
        });

        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('highlight', 512);
            $table->string('image')->nullable();
            $table->text('content');
            $table->string('status', 50)->nullable();
            $table->timestamps();

            $table->foreign('type_id')
                  ->references('id')->on('content_types')
                  ->onDelete('restrict');

            $table->foreign('category_id')
                  ->references('id')->on('content_categories')
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
        Schema::drop('contents');
        Schema::drop('content_categories');
        Schema::drop('content_types');
    }
}
