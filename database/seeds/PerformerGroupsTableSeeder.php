<?php

use Illuminate\Database\Seeder;

class PerformerGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_groups')->delete();

        \DB::table('performer_groups')->insert(array (
            0 =>
            array (
                'id' => 1,
                'performer_1_id' => 1,
                'performer_2_id' => 2,
                'total_vote' => 278,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'performer_1_id' => 3,
                'performer_2_id' => 4,
                'total_vote' => 78,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
