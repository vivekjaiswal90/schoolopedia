<?php

class SchoolSessionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('school_session')->delete();
        
		\DB::table('school_session')->insert(array (
			0 => 
			array (
				'id' => 1,
				'session_start' => '2013-04-08',
				'session_end' => '2015-04-08',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'session_start' => '2014-03-31',
				'session_end' => '2015-04-01',
				'school_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-14 05:28:04',
				'updated_at' => '2015-04-14 05:28:04',
			),
		));
	}

}
