<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersToClass extends Eloquent {

    protected $fillable = array('session_id', 'stream_id', 'section_id', 'user_id', 'class_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_to_class';

}
