<?php

class UsersToClassTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('users_to_class')->delete();
        
		\DB::table('users_to_class')->insert(array (
			0 => 
			array (
				'id' => 3,
				'session_id' => 2,
				'stream_id' => 9,
				'section_id' => 14,
				'class_id' => 27,
				'user_id' => 21,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-16 02:38:01',
				'updated_at' => '2015-04-16 02:38:01',
			),
		));
	}

}
