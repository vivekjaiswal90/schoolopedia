<?php

class UsersLoginInfoTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('users_login_info')->delete();
        
		\DB::table('users_login_info')->insert(array (
			0 => 
			array (
				'id' => 2,
				'user_id' => 22,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-14 02:51:37',
				'updated_at' => '2015-04-14 02:51:37',
			),
			1 => 
			array (
				'id' => 3,
				'user_id' => 22,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 02:18:25',
				'updated_at' => '2015-04-15 02:18:25',
			),
			2 => 
			array (
				'id' => 4,
				'user_id' => 22,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 02:19:34',
				'updated_at' => '2015-04-15 02:19:34',
			),
			3 => 
			array (
				'id' => 6,
				'user_id' => 14,
				'school_id' => 1,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:57:20',
				'updated_at' => '2015-04-15 05:57:20',
			),
			4 => 
			array (
				'id' => 7,
				'user_id' => 22,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-15 05:58:05',
				'updated_at' => '2015-04-15 05:58:05',
			),
			5 => 
			array (
				'id' => 11,
				'user_id' => 21,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-16 02:37:48',
				'updated_at' => '2015-04-16 02:37:48',
			),
			6 => 
			array (
				'id' => 12,
				'user_id' => 22,
				'school_id' => 7,
				'ip' => '',
				'latitude' => '',
				'longitude' => '',
				'area_code' => '',
				'time_zone' => '',
				'country' => '',
				'isp' => '',
				'session_length' => '00:00:00',
				'deleted_at' => '0000-00-00 00:00:00',
				'created_at' => '2015-04-16 08:10:52',
				'updated_at' => '2015-04-16 08:10:52',
			),
		));
	}

}
