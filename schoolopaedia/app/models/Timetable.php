<?php

class Timetable extends Eloquent {

    protected $fillable = array('period_id', 'class_id', 'subject_id', 'users_id', 'section_id', 'day_id');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timetable';
}
