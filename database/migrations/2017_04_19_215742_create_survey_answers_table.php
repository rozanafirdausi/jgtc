<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 64);
            $table->unsignedInteger('question_id');
            $table->enum('text_type', ['numeric', 'float', 'text', 'datetime', 'boolean']);
            $table->text('text');
            $table->integer('position_order')->default(0);
            $table->tinyInteger('is_visible')->default(1);
            $table->timestamps();

            $table->foreign('question_id')
                  ->references('id')->on('survey_questions')
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
        Schema::dropIfExists('survey_answers');
    }
}
