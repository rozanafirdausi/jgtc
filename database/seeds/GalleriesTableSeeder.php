<?php

use Illuminate\Database\Seeder;

class GalleriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('galleries')->delete();

        \DB::table('galleries')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'image',
                'title' => 'foto artist',
                'description' => NULL,
                'url' => '/foto',
                'content' => NULL,
                'position_order' => 1,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'image',
                'title' => 'poster acara',
                'description' => NULL,
                'url' => '/poster',
                'content' => NULL,
                'position_order' => 2,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            )
        ));
    }
}
