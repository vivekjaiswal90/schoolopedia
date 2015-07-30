<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Classes extends Eloquent {

    protected $fillable = array('class', 'streams_id', 'school_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'classes';

    /**
     * belong to function for activate table
     */
    public function school() {
        return $this->belongsto('activate', 'id', 'school_id');
    }

    /**
     * belong to function for Streams table
     */
    public function streams() {
        return $this->belongsto('streams', 'id', 'streams_id');
    }

    /**
     * foreign to function for sections table
     */
    public function sections() {
        return $this->hasmany('sections', 'class_id', 'id');
    }

    /**
     * foreign to function for subjects table
     */
    public function subjects() {
        return $this->hasmany('subjects', 'class_id', 'id');
    }

    /**
     * foreign to function for timetable table
     */
    public function timetable() {
        return $this->hasmany('timetable', 'classes_id', 'id');
    }


}
