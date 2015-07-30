<?php

use Cartalyst\Sentry\Groups\Eloquent\Group as SentryGroupModel;
class Groups extends SentryGroupModel {
	protected $fillable = array('name', 'permissions');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'groups';
        
        /**
         * belong to function for user table
         */
        public function user(){
            return $this->belongsto('User', 'id', 'permissions');
        }
}