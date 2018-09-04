<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBannerImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('banner_images', function(Blueprint $table) {
			$table->increments('id');
			$table->string('filename', 45);
			$table->text('text', 65535)->nullable();
			$table->string('status', 40)->nullable();
			$table->datetime('active_start_date');
			$table->datetime('active_end_date');
			$table->string('url', 255)->nullable();
			$table->string('type', 45)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('banner_images');
	}

}
