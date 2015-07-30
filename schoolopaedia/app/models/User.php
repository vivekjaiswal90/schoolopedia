<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

    use UserTrait,
        RemindableTrait;

use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $fillable = array(
        'email',
        'email_updated_at',
        'password',
        'password_updated_at',
        'permissions',
        'activated',
        'activation_code',
        'last_login',
        'persist_code',
        'reset_password_code',
        'school_id',
        'remember_token'
    );

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array(
        'password',
        'password_updated_at',
        'remember_token',
        'reset_password_code',
        'activation_code',
        'persist_code'
    );

}
