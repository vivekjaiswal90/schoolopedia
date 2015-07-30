<?php

class Periods extends Eloquent {

    protected $fillable = array('period_name', 'start_time', 'end_time', 'schedule_id');

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'periods';
}
