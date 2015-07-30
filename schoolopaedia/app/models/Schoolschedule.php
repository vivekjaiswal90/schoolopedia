<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SchoolSchedule extends Eloquent {

    protected $fillable = array('start_from', 'close_untill', 'opening_time', 'lunch_time', 'closing_time', 'school_id', 'school_session_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'school_schedule';
}
