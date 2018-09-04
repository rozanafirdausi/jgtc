<?php

use Illuminate\Database\Seeder;

class SponsorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('sponsors')->delete();

        \DB::table('sponsors')->insert(array (
            0 =>
            array (
                'id' => 1,
                'type' => 'supporter',
                'name' => 'Indofood',
                'description' => 'Indofood adalah produk asli Indonesia',
                'logo' => '7de31d53344f8d5eaa2999f9b409eed4-20180813232021-indofood-supporter.png',
                'logo_orientation' => NULL,
                'url' => 'http://www.indofood.com',
                'position_order' => '1',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            1 =>
            array (
                'id' => 2,
                'type' => 'media',
                'name' => 'Fanta',
                'description' => 'Fanta adalah merek minuman ringan berkarbonasi rasa buah yang diproduksi oleh The Coca-Cola Company.',
                'logo' => '1126bfc8ba9c3efed8f30a84783d07a6-20180813232006-fanta-organizer.png',
                'logo_orientation' => NULL,
                'url' => 'http://www.fanta.co.id',
                'position_order' => '2',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            2 =>
            array (
                'id' => 3,
                'type' => 'media',
                'name' => 'Coca-cola',
                'description' => 'Coca-Cola adalah minuman ringan berkarbonasi yang dijual di toko, restoran, dan mesin penjual di lebih dari 200 negara. Minuman ini diproduksi oleh The Coca-Cola Company asal Atlanta, Georgia, dan sering disebut Coke saja (merek dagang terdaftar The Coca-Cola Company di Amerika Serikat sejak 27 Maret 1944).',
                'logo' => 'bc9cf3bcfef7a68705f07a0292ce3e4f-20180813233032-coca-cola-supporter.png',
                'logo_orientation' => NULL,
                'url' => 'http://www.coca-cola.co.id/',
                'position_order' => '3',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            3 =>
            array (
                'id' => 4,
                'type' => 'organizer',
                'name' => 'Shopee',
                'description' => 'Shopee adalah satu dari banyak pihak yang memanfaatkan peluang tersebut dengan meramaikan segmen mobile marketplace melalui aplikasi mobile mereka untuk mempermudah transaksi jual beli melalui perangkat ponsel. Saat ini aplikasi Shopee telah tersedia untuk perangkat dengan sistem operasi Android dan iOS.',
                'logo' => '4c1c431a7c001762e84b7c6a05344c81-20180813233011-shopee-organizer.png',
                'logo_orientation' => NULL,
                'url' => 'https://shopee.co.id',
                'position_order' => '4',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
            4 =>
            array (
                'id' => 5,
                'type' => 'ticket-store',
                'name' => 'Mandiri',
                'description' => 'Bank Mandiri (IDX: BMRI) adalah bank yang berkantor pusat di Jakarta, dan merupakan bank terbesar di Indonesia dalam hal aset, pinjaman, dan deposit. Bank ini berdiri pada tanggal 2 Oktober 1998 sebagai bagian dari program restrukturisasi perbankan yang dilaksanakan oleh Pemerintah Indonesia.',
                'logo' => 'c7c508543223b3095f9d2d018cd8c463-20180813233048-mandiri-ticket-store.png',
                'logo_orientation' => NULL,
                'url' => 'https://www.bankmandiri.co.id',
                'position_order' => '5',
                'is_visible' => 1,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            ),
        ));
    }
}
