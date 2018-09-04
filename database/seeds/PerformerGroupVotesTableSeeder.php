<?php

use Illuminate\Database\Seeder;

class PerformerGroupVotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_group_votes')->delete();

        \DB::table('performer_group_votes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'performer_group_id' => 1,
                'votes' => 278,
                'notes' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => 3,
                'performer_group_id' => 2,
                'votes' => 598,
                'notes' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
