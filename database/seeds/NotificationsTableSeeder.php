<?php

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('notifications')->delete();
        
		\DB::table('notifications')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'message' => 'Tiket Anda telah terbeli sebanyak 2 buah.',
				'url' => NULL,
				'is_read' => 0,
				'created_at' => '2014-10-28 15:41:02',
				'updated_at' => '2014-10-28 15:41:02',
			),
			1 => 
			array (
				'id' => 2,
				'user_id' => 2,
				'message' => 'Tiket Anda telah terbeli sebanyak 2 buah.',
				'url' => NULL,
				'is_read' => 0,
				'created_at' => '2014-10-29 06:48:51',
				'updated_at' => '2014-10-29 06:48:51',
			),
			2 => 
			array (
				'id' => 3,
				'user_id' => 3,
				'message' => 'Tiket Anda telah terbeli sebanyak 2 buah.',
				'url' => NULL,
				'is_read' => 0,
				'created_at' => '2014-10-29 06:50:08',
				'updated_at' => '2014-10-29 06:50:08',
			),
			3 => 
			array (
				'id' => 4,
				'user_id' => 4,
				'message' => 'Tiket Anda telah terbeli sebanyak 2 buah.',
				'url' => NULL,
				'is_read' => 0,
				'created_at' => '2014-10-29 07:30:08',
				'updated_at' => '2014-10-29 07:30:08',
			)
		));
	}

}
