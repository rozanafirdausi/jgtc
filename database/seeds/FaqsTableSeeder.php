<?php

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('faqs')->delete();

        \DB::table('faqs')->insert(array (
            0 =>
            array (
                'id' => 1,
                'question' => 'Apakah bisa membelikan tiket untuk orang lain?',
                'answer' => 'Mohon pastikan jika membeli tiket mewakili orang lain untuk memasukkan kartu identitas yang diwakili.',
                'position_order' => '1',
                'icon' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'question' => 'Bagaimana prosedur penukaran ticket?',
                'answer' => 'Penukaran tiket dapat dilakukan 48 jam sebelum konser berlangsung.',
                'position_order' => '2',
                'icon' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'question' => 'Apakah tiket bisa dibeli on the spot?',
                'answer' => 'Pembelian tiket hanya dapat dilakukan melalui online pada website dan aplikasi.',
                'position_order' => '3',
                'icon' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'question' => 'Berapa maksimal pembelian tiket ?',
                'answer' => 'Pembelian maksimal 4 tiket.',
                'position_order' => '4',
                'icon' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
