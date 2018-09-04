<?php

use Illuminate\Database\Seeder;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('stages')->delete();

        \DB::table('stages')->insert(array (
            0 =>
            array (
                'id' => 1,
                'event_type' => 'event',
                'name' => 'Panggung A',
                'description' => NULL,
                'image' => NULL,
                'mc' => 'Okky Lukman',
                'position_order' => 1,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'event_type' => 'pre',
                'name' => 'Panggung B',
                'description' => NULL,
                'image' => NULL,
                'mc' => 'Najwa Shihab',
                'position_order' => 2,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'event_type' => 'pre',
                'name' => 'Panggung C',
                'description' => NULL,
                'image' => NULL,
                'mc' => 'Najwa Shihab',
                'position_order' => 2,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'event_type' => 'event',
                'name' => 'Panggung D',
                'description' => NULL,
                'image' => NULL,
                'mc' => 'Najwa Shihab',
                'position_order' => 2,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
