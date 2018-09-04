<?php

use Illuminate\Database\Seeder;

class PerformersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performers')->delete();

        \DB::table('performers')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Tulus',
                'description' => NULL,
                'avatar' => NULL,
                'job_title' => NULL,
                'institution' => NULL,
                'email' => NULL,
                'average_rate' => 4.75,
                'position_order' => 1,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
                'type' => 'national',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Sheila on 7',
                'description' => NULL,
                'avatar' => NULL,
                'job_title' => NULL,
                'institution' => NULL,
                'email' => NULL,
                'average_rate' => 5,
                'position_order' => 2,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
                'type' => 'national',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'One Direction',
                'description' => NULL,
                'avatar' => NULL,
                'job_title' => NULL,
                'institution' => NULL,
                'email' => NULL,
                'average_rate' => 5,
                'position_order' => 3,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
                'type' => 'international',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Blackpink',
                'description' => NULL,
                'avatar' => NULL,
                'job_title' => NULL,
                'institution' => NULL,
                'email' => NULL,
                'average_rate' => 5,
                'position_order' => 3,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
                'type' => 'international',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Super Junior',
                'description' => NULL,
                'avatar' => NULL,
                'job_title' => NULL,
                'institution' => NULL,
                'email' => NULL,
                'average_rate' => 5,
                'position_order' => 3,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
                'type' => 'international',
            ),
        ));
    }
}
