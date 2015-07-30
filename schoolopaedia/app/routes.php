<?php
/**
 * Created by PhpStorm.
 * User: summmmit
 * Date: 2/28/2015
 * Time: 3:23 PM
*/

/*
 * Home (get)
 */
Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@showWelcome'
));

require_once app_path().'/routes/user.php';       // including the user routes
require_once app_path().'/routes/teacher.php';      // including the teacher routes
require_once app_path().'/routes/admin.php';      // including the admin routes
require_once app_path().'/routes/school.php';      // including the main site routes