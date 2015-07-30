<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Sections extends Eloquent {

    protected $fillable = array('section_name', 'class_id');

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * belong to function for school table
     */
    public function classes() {
        return $this->belongsto('classes', 'id', 'class_id');
    }

}
