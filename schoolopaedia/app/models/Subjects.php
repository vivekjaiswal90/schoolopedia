<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Subjects extends Eloquent {

    protected $fillable = array('subject_name', 'subject_code', 'class_id', 'section_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects';

    /**
     * belong to function for school table
     */
    public function classes() {
        return $this->belongsto('classes', 'id', 'class_id');
    }
    /**
     * foreign to function for subjects table
     */
    public function timetable() {
        return $this->hasmany('timetable', 'subject_id', 'id');
    }

}
