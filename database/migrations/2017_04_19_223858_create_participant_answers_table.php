<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_answers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('participant_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('question_id')->nullable();
            $table->unsignedInteger('answer_id')->nullable();
            $table->enum('text_type', ['numeric', 'float', 'text', 'datetime', 'boolean']);
            $table->text('text');
            $table->timestamps();

            $table->foreign('participant_id')
                  ->references('id')->on('participants')
                  ->onDelete('set null');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
            $table->foreign('question_id')
                  ->references('id')->on('survey_questions')
                  ->onDelete('set null');
            $table->foreign('answer_id')
                  ->references('id')->on('survey_answers')
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
        Schema::dropIfExists('participant_answers');
    }
}
