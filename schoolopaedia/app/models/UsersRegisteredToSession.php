<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersRegisteredToSession extends Eloquent {

    protected $fillable = array('session_id', 'section_id', 'user_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_registered_to_session';

}
