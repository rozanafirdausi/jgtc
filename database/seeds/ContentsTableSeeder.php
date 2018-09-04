<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\SuitEvent\Models\Content;
use App\SuitEvent\Models\ContentCategory;
use App\SuitEvent\Models\ContentType;

class ContentsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('contents')->delete();
		\DB::table('content_categories')->delete();
		\DB::table('content_types')->delete();

		$dynamic = ContentType::create(['name' => ContentType::DYNAMIC_TYPE]);
		$staticType = ContentType::create(['name' => ContentType::STATIC_TYPE]);


		$profile = ContentCategory::create(['type_id' => $staticType->id, 'name' => 'Profile', 'slug' => str_slug('Profile')]);
		$history = ContentCategory::create(['type_id' => $staticType->id, 'name' => 'History', 'slug' => str_slug('History')]);
		$train = ContentCategory::create(['type_id' => $dynamic->id, 'name' => 'Train', 'slug' => str_slug('Train')]);
		$bus = ContentCategory::create(['type_id' => $dynamic->id, 'name' => 'Bus', 'slug' => str_slug('Bus')]);

		Content::insert(array (
			array (
				'id' => 1,
				'title' => 'profile',
				'slug' => 'profile',
				'content' => 'The 41st Jazz Goes to Campus is back! Last year, we succeeded to bring 20.000 visitors from noon to midnight and more than 35 local and international musicians on four stages. This year, we return with the theme “Bring the Jazz On!”, as we aim to make The 41st Jazz Goes to Campus jazzier than ever. ',
				'type_id' => $profile->type->id,
				'category_id' => $profile->id,
				'status' => 'published',
			),
			array (
				'id' => 2,
				'title' => 'history',
				'slug' => 'history',
				'content' => 'JGTC was first held in 1976 by a group of FEB UI Students and initiated by the famous Mr. Chandra Darusman, vocalist of the Jazz band Caseiro and current WIPO Indonesian Ambassador. ',
				'type_id' => $history->type->id,
				'category_id' => $history->id,
				'status' => 'published',
			),
			array (
				'id' => 3,
				'title' => 'USING JAKARTA COMMUTER LINE TRAIN',
				'slug' => 'train',
				'content' => 'The nearest train station to JIEXPO Kemayoran is Stasiun Rajawali on the Bogor - Jatinegara line. From the station, you can log on to the GO-JEK app and order a GO-RIDE or GO-CAR to reach the venue, or walk for 1.6 kilometers. ',
				'type_id' => $train->type->id,
				'category_id' => $train->id,
				'status' => 'published',
			),
			array (
				'id' => 4,
				'title' => 'USING TRANSJAKARTA BUS',
				'slug' => 'bus',
				'content' => 'The nearest Transjakarta Bus Stop is Jembatan Merah on Corridor 12 (Penjaringan - Tanjung Priok) and Corridor 5 (Kampung Melayu - Ancol). From the Bus Stop, you can log on to the GO-JEK app ',
				'type_id' => $bus->type->id,
				'category_id' => $bus->id,
				'status' => 'published',
			),
	));
	}

}
