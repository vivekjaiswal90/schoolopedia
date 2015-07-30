<?php

class StreamsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('streams')->delete();
        
		\DB::table('streams')->insert(array (
			0 => 
			array (
				'id' => 1,
				'stream_name' => 'Arts',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-18 02:52:13',
				'updated_at' => '2015-03-30 08:00:23',
			),
			1 => 
			array (
				'id' => 2,
				'stream_name' => 'Science',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-18 02:52:23',
				'updated_at' => '2015-03-18 02:52:23',
			),
			2 => 
			array (
				'id' => 3,
				'stream_name' => 'Commerce',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-18 02:52:31',
				'updated_at' => '2015-03-18 02:52:31',
			),
			3 => 
			array (
				'id' => 4,
				'stream_name' => 'None',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-18 02:52:39',
				'updated_at' => '2015-03-18 02:52:39',
			),
			4 => 
			array (
				'id' => 5,
				'stream_name' => 'Biology',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:18:04',
				'updated_at' => '2015-03-27 07:18:04',
			),
			5 => 
			array (
				'id' => 6,
				'stream_name' => 'Computer Science',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:19:08',
				'updated_at' => '2015-03-27 07:19:08',
			),
			6 => 
			array (
				'id' => 7,
				'stream_name' => 'Information Technology',
				'school_id' => 1,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-03-27 07:19:30',
				'updated_at' => '2015-03-27 07:19:30',
			),
			7 => 
			array (
				'id' => 8,
				'stream_name' => 'Electronics',
				'school_id' => 1,
				'deleted_at' => '2015-03-30 08:00:48',
				'created_at' => '2015-03-30 08:00:39',
				'updated_at' => '2015-03-30 08:00:48',
			),
			8 => 
			array (
				'id' => 9,
				'stream_name' => 'None',
				'school_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:58:33',
				'updated_at' => '2015-04-15 05:58:33',
			),
			9 => 
			array (
				'id' => 10,
				'stream_name' => 'Science',
				'school_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:58:41',
				'updated_at' => '2015-04-15 05:58:41',
			),
			10 => 
			array (
				'id' => 11,
				'stream_name' => 'Arts',
				'school_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:58:49',
				'updated_at' => '2015-04-15 05:58:49',
			),
			11 => 
			array (
				'id' => 12,
				'stream_name' => 'Information Technology',
				'school_id' => 7,
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:59:01',
				'updated_at' => '2015-04-15 05:59:01',
			),
		));
	}

}
