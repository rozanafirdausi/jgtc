<?php

use Illuminate\Database\Seeder;

class SurveyQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('survey_questions')->delete();

        \DB::table('survey_questions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'artist',
                'code' => '1',
                'text' => 'Bagaimana menurut anda jika kami mengundang Payung Teduh?',
                'position_order' => 1,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
