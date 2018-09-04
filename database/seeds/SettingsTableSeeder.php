<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->delete();

        $data = [
            [
                'key'   => 'site-name',
                'value' => 'Jazz Goes To Campus 2018'
            ],
            [
                'key'   => 'site-description',
                'value' => 'JGTC was first held in 1976 by a group of FEB UI Students and initiated by the famous Mr. Chandra Darusman, vocalist of the Jazz band Caseiro and current WIPO Indonesian Ambassador. '
            ],
            [
                'key'   => 'site-image',
                'value' => ''
            ],
            [
                'key'   => 'ga_script',
                'value' => ''
            ],
            [
                'key'   => 'history-image',
                'value' => 'http://via.placeholder.com/320'
            ],
            [
                'key'   => 'profile',
                'value' => 'The 41st Jazz Goes to Campus is back! Last year, we succeeded to bring 20.000 visitors from noon to midnight and more than 35 local and international musicians on four stages. This year, we return with the theme “Bring the Jazz On!”, as we aim to make The 41st Jazz Goes to Campus jazzier than ever. '
            ],
            [
                'key'   => 'train-route',
                'value' => 'The nearest train station to JIEXPO Kemayoran is Stasiun Rajawali on the Bogor - Jatinegara line. From the station, you can log on to the GO-JEK app and order a GO-RIDE or GO-CAR to reach the venue, or walk for 1.6 kilometers. '
            ],
            [
                'key'   => 'bus-route',
                'value' => 'The nearest Transjakarta Bus Stop is Jembatan Merah on Corridor 12 (Penjaringan - Tanjung Priok) and Corridor 5 (Kampung Melayu - Ancol). From the Bus Stop, you can log on to the GO-JEK app '
            ],
            [
                'key'   => 'site-plan-1',
                'value' => 'site-plan.jpg'
            ],
            [
                'key'   => 'site-plan-2',
                'value' => 'http://via.placeholder.com/941x419?text=Map+2'
            ],
            [
                'key'   => 'spotify-playlist-url',
                'value' => 'https://open.spotify.com/embed/user/21xel3hxzbkpuutsm3ewjrwla/playlist/6uGunw1F3vRr2NeT9YkluB'
            ],
            [
                'key'   => 'footer-description',
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis deleniti dolores adipisci saepe quo consequuntur aliquam distinctio, beatae ut laudantium harum iure, dolorem, ab in perspiciatis ipsam! Quaerat, id, illum. '
            ],
            [
                'key' => 'official-facebook',
                'value' => 'https://www.facebook.com/jgtcfestival/'
            ],
            [
                'key' => 'official-twitter',
                'value' => 'https://twitter.com/jgtcfestival'
            ],
            [
                'key' => 'official-instagram',
                'value' => 'https://www.instagram.com/jgtcfestival/'
            ],
            [
                'key' => 'official-phone',
                'value' => '0212345678'
            ],
            [
                'key' => 'official-email',
                'value' => 'mail@jgtc.com'
            ],
            [
                'key' => 'official-app-store',
                'value' => ''
            ],
            [
                'key' => 'official-play-store',
                'value' => ''
            ],
        ];

        \DB::table('settings')->insert($data);
    }
}
