<?php

use Illuminate\Database\Seeder;

class PerformerSpecificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_specifications')->delete();

        \DB::table('performer_specifications')->insert(array (
            0 =>
            array (
                'id' => 1,
                'performer_id' => 1,
                'type' => 'A',
                'key' => 'B',
                'value' => NULL,
                'description' => NULL,
                'position_order' => 0,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
