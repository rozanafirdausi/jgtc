<?php

use Illuminate\Database\Seeder;

class SurveyAnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('survey_answers')->delete();

        \DB::table('survey_answers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'code' => '10',
                'question_id' => 1,
                'text_type' => 'text',
                'text' => 'Bagus, Payung Teduh sedang naik daun',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'code' => '10',
                'question_id' => 1,
                'text_type' => 'text',
                'text' => 'Sebaiknya memilih bintang tamu yang banyak disukai remaja',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'code' => '10',
                'question_id' => 1,
                'text_type' => 'text',
                'text' => 'Setuju',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
