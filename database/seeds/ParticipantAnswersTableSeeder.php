<?php

use Illuminate\Database\Seeder;

class ParticipantAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('participant_answers')->delete();

        \DB::table('participant_answers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'participant_id' => 1,
                'user_id' => 1,
                'question_id' => 1,
                'answer_id' => 1,
                'text_type' => 'text',
                'text' => 'Bagus, Payung Teduh sedang naik daun',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'participant_id' => 2,
                'user_id' => 2,
                'question_id' => 1,
                'answer_id' => 1,
                'text_type' => 'text',
                'text' => 'Sebaiknya memilih bintang tamu yang banyak disukai remaja',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
