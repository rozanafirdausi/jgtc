<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('provinces')->delete();

        \DB::table('provinces')->insert(array (
            0 =>
            array (
                'id' => 85,
                'code' => '11',
                'shipment_area_code' => '21',
                'name' => 'ACEH',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-01-22 03:30:25',
            ),
            1 =>
            array (
                'id' => 86,
                'code' => '12',
                'shipment_area_code' => '34',
                'name' => 'SUMATERA UTARA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            2 =>
            array (
                'id' => 87,
                'code' => '13',
                'shipment_area_code' => '32',
                'name' => 'SUMATERA BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            3 =>
            array (
                'id' => 88,
                'code' => '14',
                'shipment_area_code' => '26',
                'name' => 'RIAU',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            4 =>
            array (
                'id' => 89,
                'code' => '15',
                'shipment_area_code' => '8',
                'name' => 'JAMBI',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            5 =>
            array (
                'id' => 90,
                'code' => '16',
                'shipment_area_code' => '33',
                'name' => 'SUMATERA SELATAN',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            6 =>
            array (
                'id' => 91,
                'code' => '17',
                'shipment_area_code' => '4',
                'name' => 'BENGKULU',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            7 =>
            array (
                'id' => 92,
                'code' => '18',
                'shipment_area_code' => '18',
                'name' => 'LAMPUNG',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            8 =>
            array (
                'id' => 93,
                'code' => '19',
                'shipment_area_code' => '2',
                'name' => 'KEPULAUAN BANGKA BELITUNG',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-01-22 03:30:25',
            ),
            9 =>
            array (
                'id' => 94,
                'code' => '21',
                'shipment_area_code' => '17',
                'name' => 'KEPULAUAN RIAU',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            10 =>
            array (
                'id' => 95,
                'code' => '31',
                'shipment_area_code' => '6',
                'name' => 'DKI JAKARTA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            11 =>
            array (
                'id' => 96,
                'code' => '32',
                'shipment_area_code' => '9',
                'name' => 'JAWA BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            12 =>
            array (
                'id' => 97,
                'code' => '33',
                'shipment_area_code' => '10',
                'name' => 'JAWA TENGAH',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            13 =>
            array (
                'id' => 98,
                'code' => '34',
                'shipment_area_code' => '5',
                'name' => 'DI YOGYAKARTA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            14 =>
            array (
                'id' => 99,
                'code' => '35',
                'shipment_area_code' => '11',
                'name' => 'JAWA TIMUR',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            15 =>
            array (
                'id' => 100,
                'code' => '36',
                'shipment_area_code' => '3',
                'name' => 'BANTEN',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            16 =>
            array (
                'id' => 101,
                'code' => '51',
                'shipment_area_code' => '1',
                'name' => 'BALI',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            17 =>
            array (
                'id' => 102,
                'code' => '52',
                'shipment_area_code' => '22',
                'name' => 'NUSA TENGGARA BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-01-22 03:30:25',
            ),
            18 =>
            array (
                'id' => 103,
                'code' => '53',
                'shipment_area_code' => '23',
                'name' => 'NUSA TENGGARA TIMUR',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-01-22 03:30:25',
            ),
            19 =>
            array (
                'id' => 104,
                'code' => '61',
                'shipment_area_code' => '12',
                'name' => 'KALIMANTAN BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            20 =>
            array (
                'id' => 105,
                'code' => '62',
                'shipment_area_code' => '14',
                'name' => 'KALIMANTAN TENGAH',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            21 =>
            array (
                'id' => 106,
                'code' => '63',
                'shipment_area_code' => '13',
                'name' => 'KALIMANTAN SELATAN',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            22 =>
            array (
                'id' => 107,
                'code' => '64',
                'shipment_area_code' => '15',
                'name' => 'KALIMANTAN TIMUR',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            23 =>
            array (
                'id' => 108,
                'code' => '65',
                'shipment_area_code' => '16',
                'name' => 'KALIMANTAN UTARA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            24 =>
            array (
                'id' => 109,
                'code' => '71',
                'shipment_area_code' => '31',
                'name' => 'SULAWESI UTARA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            25 =>
            array (
                'id' => 110,
                'code' => '72',
                'shipment_area_code' => '29',
                'name' => 'SULAWESI TENGAH',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            26 =>
            array (
                'id' => 111,
                'code' => '73',
                'shipment_area_code' => '28',
                'name' => 'SULAWESI SELATAN',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            27 =>
            array (
                'id' => 112,
                'code' => '74',
                'shipment_area_code' => '30',
                'name' => 'SULAWESI TENGGARA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            28 =>
            array (
                'id' => 113,
                'code' => '75',
                'shipment_area_code' => '7',
                'name' => 'GORONTALO',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:37',
            ),
            29 =>
            array (
                'id' => 114,
                'code' => '76',
                'shipment_area_code' => '27',
                'name' => 'SULAWESI BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            30 =>
            array (
                'id' => 115,
                'code' => '81',
                'shipment_area_code' => '19',
                'name' => 'MALUKU',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            31 =>
            array (
                'id' => 116,
                'code' => '82',
                'shipment_area_code' => '20',
                'name' => 'MALUKU UTARA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            32 =>
            array (
                'id' => 117,
                'code' => '91',
                'shipment_area_code' => '25',
                'name' => 'PAPUA BARAT',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
            33 =>
            array (
                'id' => 118,
                'code' => '94',
                'shipment_area_code' => '24',
                'name' => 'PAPUA',
                'created_at' => '2016-01-22 03:30:25',
                'updated_at' => '2016-06-23 06:49:38',
            ),
        ));


    }
}
