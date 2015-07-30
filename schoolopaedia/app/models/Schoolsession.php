<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SchoolSession extends Eloquent {

    protected $fillable = array('session_start', 'session_end', 'school_id', 'current_session');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'school_session';
}
