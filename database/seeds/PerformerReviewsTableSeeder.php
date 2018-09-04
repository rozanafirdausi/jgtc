<?php

use Illuminate\Database\Seeder;

class PerformerReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_reviews')->delete();

        \DB::table('performer_reviews')->insert(array (
            0 =>
            array (
                'id' => 1,
                'parent_id' => 1,
                'performer_id' => 1,
                'user_id' => 1,
                'rate' => 4,
                'note' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'parent_id' => 2,
                'performer_id' => 1,
                'user_id' => 1,
                'rate' => 3,
                'note' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
