<?php

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('schedules')->delete();

        \DB::table('schedules')->insert(array (
            0 =>
            array (
                'id' => 1,
                'event_type' => 'pre',
                'title' => 'Ticket Sell',
                'description' => NULL,
                'image' => NULL,
                'banner' => NULL,
                'stage_id' => 1,
                'location' => NULL,
                'start_date' => '2018-06-01 18:00:00',
                'end_date' => '2018-06-01 18:15:00',
                'total_rate' => '',
                'max_participant' => '',
                'num_participant' => '',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'event_type' => 'event',
                'title' => 'Penampilan Musik Jazz',
                'description' => NULL,
                'image' => NULL,
                'banner' => NULL,
                'stage_id' => 2,
                'location' => NULL,
                'start_date' => '2018-06-01 15:00:00',
                'end_date' => '2018-06-01 18:00:00',
                'total_rate' => '',
                'max_participant' => '',
                'num_participant' => '',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'event_type' => 'pre',
                'title' => 'JGTC Conference',
                'description' => NULL,
                'image' => NULL,
                'banner' => NULL,
                'stage_id' => 3,
                'location' => NULL,
                'start_date' => '2018-06-01 19:00:00',
                'end_date' => '2018-06-01 21:15:00',
                'total_rate' => '',
                'max_participant' => '',
                'num_participant' => '',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'event_type' => 'event',
                'title' => 'Penampilan Musik Jazz',
                'description' => NULL,
                'image' => NULL,
                'banner' => NULL,
                'stage_id' => 1,
                'location' => NULL,
                'start_date' => '2018-06-01 07:00:00',
                'end_date' => '2018-06-01 18:00:00',
                'total_rate' => '',
                'max_participant' => '',
                'num_participant' => '',
                'position_order' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
