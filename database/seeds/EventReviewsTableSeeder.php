<?php

use Illuminate\Database\Seeder;

class EventReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('event_reviews')->delete();

        \DB::table('event_reviews')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 1,
                'name' => 'User 1',
                'stars' => 5,
                'text' => 'Acaranya meriah dan sesuai ekspektasi',
                'is_featured' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => 2,
                'name' => 'User 2',
                'stars' => 4,
                'text' => 'Bagus dan tepat waktu',
                'is_featured' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'user_id' => 3,
                'name' => 'User 3',
                'stars' => 5,
                'text' => NULL,
                'is_featured' => 0,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
