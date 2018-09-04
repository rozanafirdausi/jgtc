<?php

use Illuminate\Database\Seeder;

class DiscussionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('discussions')->delete();

        \DB::table('discussions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'message' => 'apakah harga tiket berdasarkan tipe?',
                'category_id' => 1,
                'user_id' => NULL,
                'participant_id' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'message' => 'eventnya tanggal berapa rencananya?',
                'category_id' => 2,
                'user_id' => NULL,
                'participant_id' => 2,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'message' => 'berapa jumlah uang dari sponsor yang sudah diterima?',
                'category_id' => 4,
                'user_id' => NULL,
                'participant_id' => 2,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'message' => 'pemilihan panitia berdasarkan apa?',
                'category_id' => 3,
                'user_id' => NULL,
                'participant_id' => 3,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            4 =>
            array (
                'id' => 5,
                'message' => 'event menghabiskan biaya berapa?',
                'category_id' => 2,
                'user_id' => NULL,
                'participant_id' => 3,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            5 =>
            array (
                'id' => 6,
                'message' => 'event mengundang artis siapa?',
                'category_id' => 2,
                'user_id' => NULL,
                'participant_id' => 3,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            )
        ));
    }
}
