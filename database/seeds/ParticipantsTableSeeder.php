<?php

use Illuminate\Database\Seeder;

class ParticipantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('participants')->delete();

        \DB::table('participants')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'umum',
                'name' => 'Sirria Panah Alam',
                'email' => 'user1@mail.com',
                'phone' => NULL,
                'avatar' => NULL,
                'user_id' => 1,
                'city_id' => 8377,
                'position_order' => '1',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'umum',
                'name' => 'Mutia Rahmi Dewi',
                'email' => 'user2@mail.com',
                'phone' => NULL,
                'avatar' => NULL,
                'user_id' => 2,
                'city_id' => 8378,
                'position_order' => '1',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'type' => 'umum',
                'name' => 'Sirria Panah',
                'email' => 'user3@mail.com',
                'phone' => NULL,
                'avatar' => NULL,
                'user_id' => 3,
                'city_id' => 8377,
                'position_order' => '1',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'type' => 'umum',
                'name' => 'Astrid Febrianca',
                'email' => 'user4@mail.com',
                'phone' => NULL,
                'avatar' => NULL,
                'user_id' => 4,
                'city_id' => 8377,
                'position_order' => '1',
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
