<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Streams extends Eloquent {

    protected $fillable = array('stream_name', 'school_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'streams';

    /**
     * belong to function for activate table
     */
    public function school() {
        return $this->belongsto('activate', 'id', 'school_id');
    }

    /**
     * belong to function for classes table
     */
    public function classes() {
        return $this->hasMany('classes', 'streams_id', 'id');
    }

}
