<?php

class PeriodProfile extends Eloquent {

    protected $fillable = array('profile_name', 'school_id', 'current_profile');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'period_profile';

}
