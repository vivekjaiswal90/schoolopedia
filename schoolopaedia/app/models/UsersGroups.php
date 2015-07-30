<?php

class UsersGroups extends Eloquent {

    protected $fillable = array('user_id', 'groups_id');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups';

}
