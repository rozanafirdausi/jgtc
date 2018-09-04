<?php

use Illuminate\Database\Seeder;

class PerformerCandidatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('performer_candidates')->delete();

        \DB::table('performer_candidates')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'group',
                'collab_type' => 'main',
                'name' => 'Tulus',
                'description' => NULL,
                'avatar' => NULL,
                'position_order' => 2,
                'total_vote' => 740,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'group',
                'collab_type' => 'main',
                'name' => 'Sheila On 7',
                'description' => NULL,
                'avatar' => NULL,
                'position_order' => 1,
                'total_vote' => 1165,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'type' => 'group',
                'collab_type' => 'support',
                'name' => 'Geisha',
                'description' => NULL,
                'avatar' => NULL,
                'position_order' => 3,
                'total_vote' => 1168,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'type' => 'group',
                'collab_type' => 'support',
                'name' => 'Armada',
                'description' => NULL,
                'avatar' => NULL,
                'position_order' => 4,
                'total_vote' => 989,
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
