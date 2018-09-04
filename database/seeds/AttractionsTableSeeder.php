<?php

use Illuminate\Database\Seeder;

class AttractionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('attractions')->delete();

        \DB::table('attractions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'tenant',
                'name' => 'Musik Jazz',
                'description' => 'Musik Jazz merupakan acara utama dalam JGTC 2018',
                'image' => NULL,
                'latitude' => 7.6473,
                'longitude' => 121.7882,
                'pin_point_code' => 2,
                'position_order' => '1',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'tenant',
                'name' => 'Musik Jazz',
                'description' => 'Musik Jazz merupakan acara utama dalam JGTC 2018',
                'image' => NULL,
                'latitude' => 8.2532,
                'longitude' => 105.2623,
                'pin_point_code' => 1,
                'position_order' => '2',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'type' => 'tenant',
                'name' => 'Musik Jazz',
                'description' => 'Musik Jazz merupakan acara utama dalam JGTC 2018',
                'image' => NULL,
                'latitude' => 8.2532,
                'longitude' => 105.2623,
                'pin_point_code' => 3,
                'position_order' => '3',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
