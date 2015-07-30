<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UsersLoginInfo extends Eloquent {

    protected $fillable = array('users_id', 'school_id', 'ip', 'latitude', 'longitude', 'area_code', 'time_zone', 'country', 'isp', 'session_length');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_login_info';

}
