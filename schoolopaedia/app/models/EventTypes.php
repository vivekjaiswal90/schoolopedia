<?php

class EventTypes extends Eloquent {

    protected $fillable = array('event_type_name', 'school_id');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_types';

}
