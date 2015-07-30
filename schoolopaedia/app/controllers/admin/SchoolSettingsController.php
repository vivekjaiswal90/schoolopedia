<?php

/**
 * Description of AdminAccountController
 *
 * @author 1084760
 */
class SchoolSettingsController extends BaseController {

    protected $user;
    protected $schoolId;
    protected $schoolSessionId;

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

    protected function getSchoolSessionId() {

        $session = SchoolSession::where('school_id', '=', $this->getschoolId())
                        ->where('current_session', '=', 1)
                        ->get()->first();

        return $this->schoolSessionId = $session->id;
    }

    public function postSetSchoolSessions() {
        $start_session_from = Input::get('start_session_from');
        $end_session_untill = Input::get('end_session_untill');
        $current_session = Input::get('current_session');

        $school_session = new SchoolSession();
        $school_session->session_start = $start_session_from;
        $school_session->session_end = $end_session_untill;
        $school_session->school_id = Sentry::getUser()->school_id;
        $school_session->current_session = ($current_session == "on") ? 1 : 0;

        $school_session->save();

        return Redirect::route('admin-home')->with('global', 'Thanks , You have set Current Session of The School');
    }

    public function getSchoolSessions() {
        $session = SchoolSession::where('school_id', '=', $this->getschoolId())->get();
    }

    //for the school schedules

    public function postSetSchoolSchedule() {

        $schedule_starts_from = Input::get('schedule_starts_from');
        $schedule_ends_untill = Input::get('schedule_ends_untill');
        $school_opening_time = Input::get('school_opening_time');
        $school_lunch_time = Input::get('school_lunch_time');
        $school_closing_time = Input::get('school_closing_time');

        $school_schedule = new SchoolSchedule();
        $school_schedule->start_from = $schedule_starts_from;
        $school_schedule->close_untill = $schedule_ends_untill;
        $school_schedule->opening_time = $school_opening_time;
        $school_schedule->lunch_time = $school_lunch_time;
        $school_schedule->closing_time = $school_closing_time;
        $school_schedule->school_id = $this->getSchoolId();
        $school_schedule->school_session_id = $this->getSchoolSessionId();

        if ($school_schedule->save()) {

            $response = array(
                'status' => 'OK',
                'result' => array(
                    'schedule' => $school_schedule,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'Error',
                'result' => array(
                    'schedule' => 'none',
                )
            );

            return Response::json($response);
        }
    }

    public function getSchoolSettings() {

        $school = Schools::find($this->getSchoolId());

        $schedule = SchoolSchedule::where('school_id', '=', $this->getschoolId())
                ->where('school_session_id', '=', $this->getSchoolSessionId())
                ->get();
        $sessions = SchoolSession::where('school_id', '=', $this->getschoolId())->get();
        $current_session = SchoolSession::where('school_id', '=', $this->getschoolId())
                        ->where('current_session', '=', 1)->get()->first();

        return View::make('admin.school-settings')
                        ->with('schedules', $schedule)
                        ->with('sessions', $sessions)
                        ->with('school', $school)
                        ->with('current_session', $current_session);
    }

    public function postScheduleStartFrom() {

        $schedule = SchoolSchedule::find(Input::get('pk'));
        $schedule->opening_time = Input::get('value');

        if ($schedule->save()) {

            $response = array(
                'status' => 'OK',
                'msg' => 'Updated created successfully',
                'errors' => null,
                'result' => array(
                    'schedule' => $schedule,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'Error',
                'msg' => 'Not Updated',
                'errors' => null,
                'result' => array(
                    'schedule' => 'none',
                )
            );

            return Response::json($response);
        }
    }

    public function postScheduleLunchFrom() {

        $schedule = SchoolSchedule::find(Input::get('pk'));
        $schedule->lunch_time = Input::get('value');

        if ($schedule->save()) {

            $response = array(
                'status' => 'OK',
                'msg' => 'Updated created successfully',
                'errors' => null,
                'result' => array(
                    'schedule' => $schedule,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'Error',
                'msg' => 'Not Updated',
                'errors' => null,
                'result' => array(
                    'schedule' => 'none',
                )
            );

            return Response::json($response);
        }
    }

    public function postScheduleCloseFrom() {

        $schedule = SchoolSchedule::find(Input::get('pk'));
        $schedule->closing_time = Input::get('value');

        if ($schedule->save()) {

            $response = array(
                'status' => 'OK',
                'msg' => 'Updated created successfully',
                'errors' => null,
                'result' => array(
                    'schedule' => $schedule,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'Error',
                'msg' => 'Not Updated',
                'errors' => null,
                'result' => array(
                    'schedule' => 'none',
                )
            );

            return Response::json($response);
        }
    }

    public function getSchoolStudentDetails() {
        $query = "select * from users
                  join users_groups
                  on users.id=users_groups.user_id and users_groups.groups_id=? and users.school_id=?
                  join user_details
                  on users.id=user_details.user_id
                  join users_to_class
                  on users_to_class.user_id=users.id";
        $all_users = DB::select($query, array(2, $this->getSchoolId()));

        return View::make('admin.school-students')->with('users', $all_users);
    }

    public function getSchoolStudents() {
        $query = "select
                        users.id,
                        users.school_id,
                        user_details.username,
                        user_details.first_name,
                        user_details.last_name,
                        users_to_class.class_id,
                        users_to_class.section_id,
                        user_details.pic
                  from users
                  join users_groups
                  on users.id=users_groups.user_id and users_groups.groups_id=? and users.school_id=?
                  join user_details
                  on users.id=user_details.user_id
                  join users_to_class
                  on users_to_class.user_id=users.id";
        $all_school_users = DB::select($query, array(2, $this->getSchoolId()));
        $i = 0;
        foreach ($all_school_users as $all_school_user) {

            $class = Classes::find($all_school_user->class_id)->get()->first();
            $all_users[$i]['class_name'] = $class->class;
            $section = Sections::find($all_school_user->section_id);
            $all_users[$i]['section_name'] = $section->section_name;

            $all_users[$i]['username'] = $all_school_user->username;
            $all_users[$i]['first_name'] = $all_school_user->first_name;
            $all_users[$i]['last_name'] = $all_school_user->last_name;
            $all_users[$i]['pic'] = $all_school_user->pic;
            $all_users[$i]['id'] = $all_school_user->id;
            $all_users[$i]['school_id'] = $all_school_user->school_id;
            $i++;
        }

        return View::make('admin.school-students')->with('users', $all_users);
    }

    public function getSchoolTeachers() {
        $query = "select
                        users.id,
                        users.school_id,
                        user_details.username,
                        user_details.first_name,
                        user_details.last_name,
                        users_to_class.class_id,
                        users_to_class.section_id,
                        user_details.pic
                  from users
                  join users_groups
                  on users.id=users_groups.user_id and users_groups.groups_id=? and users.school_id=?
                  join user_details
                  on users.id=user_details.user_id
                  join users_to_class
                  on users_to_class.user_id=users.id";
        $all_school_teachers = DB::select($query, array(3, $this->getSchoolId()));
        $all_teachers = 1;
        return View::make('admin.school-teachers')->with('teachers', $all_teachers);
    }

    public function getSchoolPeriods() {

        $schedules = SchoolSchedule::where('school_id', '=', $this->getschoolId())
                ->where('school_session_id', '=', $this->getSchoolSessionId())
                ->get();

        $current_schedule = SchoolSchedule::where('school_id', '=', $this->getSchoolId())->where('current_schedule', '=', 1)->get()->first();

        $periods_profiles = PeriodProfile::where('school_id', '=', $this->getSchoolId())->get();

        $current_periods_profiles = PeriodProfile::where('school_id', '=', $this->getSchoolId())
                        ->where('current_profile', '=', 1)->get();
        $periods = Periods::all();
        //$periods = "hello";
        return View::make('admin.school-periods')->with('periods_profiles', $periods_profiles)->with('current_periods_profiles', $current_periods_profiles)->with('schedules', $schedules);
    }

    public function postSetSchoolPeriods() {

        $period_id = Input::get('period_id');
        $period_name = Input::get('period_name');
        $start_time = Input::get('start_time');
        $end_time = Input::get('end_time');
        $period_profile_id = Input::get('period_profile_id');
        if ($period_id) {
            $period = Periods::find($period_id);
        } else {
            $period = new Periods();
        }

        $period->period_name = $period_name;
        $period->start_time = $start_time;
        $period->end_time = $end_time;

        if ($period->save()) {

            $period_to_period_profile = new PeriodToPeriodProfile();
            $period_to_period_profile->period_id = $period->id;
            $period_to_period_profile->profile_id = $period_profile_id;

            if ($period_to_period_profile->save()) {

                $response = array(
                    'status' => 'success',
                    'result' => array(
                        'period' => $period,
                        'period_to_period_profile' => $period_to_period_profile
                    )
                );

                return Response::json($response);
            }
        }
    }

    public function postDeleteSchoolPeriods() {

        $period_id = Input::get('period_id');
        $period_name = Input::get('period_name');
        $start_time = Input::get('start_time');
        $end_time = Input::get('end_time');
        $period_profile_id = Input::get('period_profile_id');

        if ($period_id) {

            $period_to_period_profile = PeriodToPeriodProfile::where('period_id', '=', $period_id)
                    ->where('profile_id', '=', $period_profile_id);

            if ($period_to_period_profile->delete()) {

                $period = Periods::find($period_id);

                if ($period->delete()) {

                    $response = array(
                        'status' => 'success',
                        'result' => array(
                            'period' => $period,
                        )
                    );

                    return Response::json($response);
                } else {

                    $response = array(
                        'status' => 'failed',
                        'msg' => 'Period cant be deleted',
                        'result' => array(
                            'period' => "none",
                        )
                    );

                    return Response::json($response);
                }
            } else {

                $response = array(
                    'status' => 'failed',
                    'msg' => 'Period to Period Profile cant be deleted',
                    'result' => array(
                        'period' => "none",
                    )
                );

                return Response::json($response);
            }
        } else {

            $response = array(
                'status' => 'failed',
                'result' => array(
                    'period' => "none",
                )
            );

            return Response::json($response);
        }
    }

    public function postSetSchoolPeriodsProfile() {

        $profile_name = Input::get('profile_name');

        $profile = new PeriodProfile();
        $profile->profile_name = $profile_name;
        $profile->school_id = $this->getSchoolId();

        $profile->save();

        $response = array(
            'status' => 'success',
            'result' => array(
                'profile' => $profile,
            )
        );

        return Response::json($response);
    }

    public function postGetSchoolPeriodsProfileById() {

        $period_profile_id = Input::get('period_profile_id');

        $period_profile = PeriodProfile::find($period_profile_id);

        $period_to_period_profiles = PeriodToPeriodProfile::where('profile_id', '=', $period_profile_id)->get();
        $periods = array();
        $i = 0;
        foreach ($period_to_period_profiles as $period_to_period_profile) {
            $periods[$i++] = Periods::where('id', '=', $period_to_period_profile->period_id)->get()->first();
        }

        $response = array(
            'status' => 'success',
            'result' => array(
                'periods_to_period_profiles' => $period_to_period_profiles,
                'periods' => $periods,
                'profile' => $period_profile
            )
        );

        return Response::json($response);
    }

    public function postMakeCurrentPeriodProfile() {

        $profile_id = Input::get('profile_id');

        if ($profile_id) {

            $current_period_profile = PeriodProfile::where('current_profile', '=', 1)->get()->first();

            if ($current_period_profile->count() > 0) {
                $current_period_profile->current_profile = 0;

                if ($current_period_profile->save()) {

                    $period_profile = PeriodProfile::find($profile_id);
                    $period_profile->current_profile = 1;
                    if ($period_profile->save()) {

                        $response = array(
                            'status' => 'success',
                            'msg' => 'Current Profile Changed Successfully',
                            'result' => array(
                                'period_profile' => $period_profile
                            )
                        );

                        return Response::json($response);
                    }
                } else {

                    $response = array(
                        'status' => 'failed',
                        'msg' => 'Current Profile is not Changed',
                        'result' => array(
                            'period_profile' => 'none'
                        )
                    );

                    return Response::json($response);
                }
            }
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'No Value is Passed as Profile Id',
                'result' => array(
                    'period_profile' => 'none'
                )
            );

            return Response::json($response);
        }
    }

    public function postGetCurrentPeriodProfilePeriods() {

        $query = "SELECT periods.id, periods.period_name 
                  FROM  `periods` 
                  JOIN period_to_period_profile 
                  ON period_to_period_profile.period_id = periods.id
                  JOIN period_profile 
                  ON period_profile.id = period_to_period_profile.profile_id
                  WHERE period_profile.current_profile =?";

        $periods = DB::select($query, array(1));

        $response = array(
            'status' => 'success',
            'msg' => 'All Periods Successfully Retrieved',
            'result' => array(
                'periods' => $periods
            )
        );

        return Response::json($response);
    }

}
