<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SessionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('sessions')->delete();
        
		\DB::table('sessions')->insert(array (
			0 => 
			array (
				'id' => '4294967295',
				'payload' => 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0tha3B1aHZRNk1YZkNTbk1IWUhVUEdtVlh3RGhmS0QxeklielJrUyI7czoyMjoiUEhQREVCVUdCQVJfU1RBQ0tfREFUQSI7YTowOnt9czo5OiJfc2YyX21ldGEiO2E6Mzp7czoxOiJ1IjtpOjE0MTI4NTM3Mzk7czoxOiJjIjtpOjE0MTI4NTM3Mzk7czoxOiJsIjtzOjE6IjAiO31zOjU6ImZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',
				'last_activity' => 1412853739,
				'created_at' => '2014-12-02 00:00:00',
				'updated_at' => '2014-12-02 00:00:00',
			),
		));
	}

}
