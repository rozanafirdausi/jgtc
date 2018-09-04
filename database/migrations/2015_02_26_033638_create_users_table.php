<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username', 45);
			$table->string('password', 80);
			$table->string('picture', 45)->nullable();
			$table->string('name', 255);
			$table->date('birthdate');
			$table->string('address_street', 45)->nullable();
			$table->string('address_country', 45)->nullable();
			$table->string('address_zipcode', 10)->nullable();
			$table->string('role', 50);
			$table->boolean('newsletter')->nullable();
			$table->boolean('message')->nullable();
			$table->string('email', 255);
			$table->string('phone_number', 15)->nullable();
			$table->datetime('registration_date');
			$table->datetime('last_visit');
			$table->boolean('is_premium')->nullable();
			$table->datetime('premium_expired_date')->nullable();
			$table->string('status', 45)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->integer('escrow_amount')->nullable();
			$table->integer('location_id')->nullable();
			$table->string('fb_id', 255)->nullable();
			$table->string('shop_name', 45)->nullable();
			$table->text('shop_description')->nullable();
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
		Schema::drop('users');
	}

}
