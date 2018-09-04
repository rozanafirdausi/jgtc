<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BannerImagesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('banner_images')->delete();
        
        \DB::table('banner_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'kamera',
                'filename' => 'medium-banner-2.jpg',
                'text' => 'Sony Handycam New HiTech',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:26:58',
                'active_end_date' => '2014-10-08 15:27:00',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:27:03',
                'updated_at' => '2015-02-12 09:43:06',
                'type' => 'main-banner',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'gadget',
                'filename' => 'medium-banner-1.jpg',
                'text' => 'Galaxy Note 3 + Gear Promo',
                'status' => 'active',
                'active_start_date' => '2015-02-07 15:30:47',
                'active_end_date' => '2015-04-05 15:30:48',
                'url' => 'http://chipsakti.suitdev.com/productdetail/35',
                'created_at' => '2014-10-07 08:30:50',
                'updated_at' => '2015-02-12 09:41:06',
                'type' => 'main-banner',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'test',
                'filename' => 'medium-banner-3.jpg',
                'text' => 'test',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:31:14',
                'active_end_date' => '2014-10-07 15:31:16',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:31:18',
                'updated_at' => '2014-10-07 08:31:18',
                'type' => 'main-banner',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'test',
                'filename' => 'medium-banner-4.jpg',
                'text' => 'test',
                'status' => 'active',
                'active_start_date' => '2014-10-22 15:31:31',
                'active_end_date' => '2014-10-10 15:31:33',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:31:36',
                'updated_at' => '2014-10-07 08:31:36',
                'type' => 'main-banner',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'test',
                'filename' => 'small-banner-1.jpg',
                'text' => 'sad',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:45:14',
                'active_end_date' => '2014-10-08 15:45:15',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:45:17',
                'updated_at' => '2014-10-07 08:45:17',
                'type' => 'side-banner',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'test',
                'filename' => 'small-banner-2.jpg',
                'text' => 'ssd',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:45:37',
                'active_end_date' => '2014-10-08 15:45:38',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:45:41',
                'updated_at' => '2014-10-07 08:45:41',
                'type' => 'side-banner',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'test',
                'filename' => 'small-banner-3.jpg',
                'text' => 'adsad',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'side-banner',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'PRESALE',
                'filename' => 'bunga.jpg',
                'text' => '85K',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'ticket',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Kaos JGTC',
                'filename' => '01abfc750a0c942167651c40d088531d-20180814123128.png',
                'text' => '74.000',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'merch',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'OTS',
                'filename' => 'bunga.jpg',
                'text' => '95K',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'ticket',
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'Kaos JGTC',
                'filename' => '01abfc750a0c942167651c40d088531d-20180814123128.png',
                'text' => '74.000',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'merch',
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'Kaos JGTC',
                'filename' => '01abfc750a0c942167651c40d088531d-20180814123128.png',
                'text' => '74.000',
                'status' => 'active',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'merch',
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'Presale',
                'filename' => 'bunga.jpg',
                'text' => '85K',
                'status' => 'inactive',
                'active_start_date' => '2014-10-07 15:46:01',
                'active_end_date' => '2014-10-08 15:46:03',
                'url' => 'http://google.com',
                'created_at' => '2014-10-07 08:46:06',
                'updated_at' => '2014-10-07 08:46:06',
                'type' => 'ticket',
            ),
        ));
    }

}
