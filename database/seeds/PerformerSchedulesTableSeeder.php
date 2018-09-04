<?php

use Illuminate\Database\Seeder;

class PerformerSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_schedules')->delete();

        \DB::table('performer_schedules')->insert(array (
            0 =>
            array (
                'id' => 1,
                'performer_id' => 2,
                'schedule_id' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'performer_id' => 3,
                'schedule_id' => 3,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'performer_id' => 4,
                'schedule_id' => 2,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'performer_id' => 1,
                'schedule_id' => 4,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
