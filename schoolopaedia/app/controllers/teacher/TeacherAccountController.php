<?php

class TeacherAccountController extends BaseController {

    protected $user;
    protected $schoolId;

    public function __construct() {

        $this->user = Sentry::getUser();

        $this->schoolId = $this->user->school_id;
    }

    protected function getUser() {
        return $this->user;
    }

    protected function getSchoolId() {
        return $this->schoolId;
    }

    public function getTeacherProfile() {
        $user = $this->getUser();
        $user_details = UserDetails::where('user_id', '=', $user->id)->get()->first();
        return View::make('teacher.profile')->with('user', $user)->with('user_details', $user_details);
    }

    public function getAttendance() {
        return View::make('teacher.attendance');
    }

}
