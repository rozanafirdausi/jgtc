<?php

use Illuminate\Database\Seeder;

class DynamicMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dynamic_menus')->delete();

        \DB::table('dynamic_menus')->insert(array (
            0 =>
            array (
                'id' => 1,
                'position' => 'web-header',
                'position_order' => '1',
                'label' => 'Home',
                'url' => '#home',
                'status' => 'active',
                'parent_id' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'position' => 'web-header',
                'position_order' => '2',
                'label' => 'Ticket',
                'url' => '#ticket',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'position' => 'web-header',
                'position_order' => '3',
                'label' => 'Line Up',
                'url' => '#lineup',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'position' => 'web-header',
                'position_order' => '4',
                'label' => 'Rundown',
                'url' => '#schedule',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            4 =>
            array (
                'id' => 5,
                'position' => 'web-header',
                'position_order' => '5',
                'label' => 'FAQ',
                'url' => '#information',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            5 =>
            array (
                'id' => 6,
                'position' => 'web-header',
                'position_order' => '6',
                'label' => 'Venue',
                'url' => '#venue',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            6 =>
            array (
                'id' => 7,
                'position' => 'web-header',
                'position_order' => '7',
                'label' => 'Pre-Event',
                'url' => '#pre-event',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            7 =>
            array (
                'id' => 8,
                'position' => 'web-header',
                'position_order' => '8',
                'label' => 'playlist',
                'url' => '#playlist',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            8 =>
            array (
                'id' => 9,
                'position' => 'web-header',
                'position_order' => '9',
                'label' => 'merchandise',
                'url' => '#merchandise',
                'status' => 'active',
                'parent_id' => null,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
