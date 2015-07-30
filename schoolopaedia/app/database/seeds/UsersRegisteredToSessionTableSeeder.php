<?php

class UsersRegisteredToSessionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('users_registered_to_session')->delete();
        
	}

}
