<?php

class PeriodToPeriodProfile extends Eloquent {

    protected $fillable = array('profile_id', 'period_id');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'period_to_period_profile';

}
