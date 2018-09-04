<?php

use Illuminate\Database\Seeder;

class EmailSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('email_settings')->delete();

        \DB::table('email_settings')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'example',
                'template' => 'example',
                'subject' => NULL,
                'action_button_text' => NULL,
                'before_action_button' => NULL,
                'after_action_button' => NULL,
                'created_at' => '2018-06-01 08:59:19',
                'updated_at' => '2018-06-23 07:25:10',
            )
        ));
    }
}
