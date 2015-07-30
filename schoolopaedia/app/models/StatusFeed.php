<?php

  class Statusfeed extends Eloquent {
    protected $fillable = array('status_comment', 'image_url', 'location_longigute' , 'location_lattitude' , 'video_url');
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'status_feed';



  }