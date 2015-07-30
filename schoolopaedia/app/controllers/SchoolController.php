<?php

class SchoolController extends BaseController {

    public function getCreate() {
        return View::make('schools.register');
    }

    public function postCreate() {

        $validator = Validator::make(Input::all(), array(
                    'school_name' => 'required|max:30',
                    'manager_name' => 'required|max:30',
                    'phone_number' => 'required|max:15',
                    'add_1' => 'required',
                    'city' => 'required|max:30',
                    'state' => 'required|max:30',
                    'country' => 'required',
                    'pin_code' => 'required|max:10',
                    'email' => 'max:60|email|unique:schools'
                        )
        );
        if ($validator->fails()) {
            return Redirect::route('activate-account-create')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $school_name = Input::get('school_name');
            $manager_name = Input::get('manager_name');
            $phone_number = Input::get('phone_number');
            $add_1 = Input::get('add_1');
            $add_2 = Input::get('add_2');
            $city = Input::get('city');
            $state = Input::get('state');
            $country = Input::get('country');
            $pin_code = Input::get('pin_code');
            $email = Input::get('email');

            //Registration Code
            $registration_code = str_random(50);
            //staff Code
            $code_for_teachers = str_random(60);
            //students Code
            $code_for_students = str_random(70);
            //moderators Code
            $code_for_parents = str_random(95);
            //students Code
            $code_for_admin = str_random(80);
            //moderators Code
            $code_for_moderators = str_random(90);

            $today = date("Y-m-d H:i:s");

            $school = Schools::create(array(
                        'school_name' => ucwords($school_name),
                        'manager_full_name' => ucwords($manager_name),
                        'phone_number' => $phone_number,
                        'email' => $email,
                        'add_1' => ucwords($add_1),
                        'add_2' => ucwords($add_2),
                        'city' => ucwords($city),
                        'state' => $state,
                        'country' => $country,
                        'pin_code' => $pin_code,
                        'registration_code' => $registration_code,
                        'code_for_admin' => $code_for_admin,
                        'code_for_moderators' => $code_for_moderators,
                        'code_for_teachers' => $code_for_teachers,
                        'code_for_parents' => $code_for_parents,
                        'code_for_students' => $code_for_students,
                        'active' => 0,
                        'registration_date' => $today,
            ));

            if ($school) {

                //send email
                Mail::send('emails.auth.activate.activate-school', array('link' => URL::route('activate-account-activate', $registration_code), 'school_name' => $school_name, 'adminCode' => $code_for_admin, 'teachersCode' => $code_for_teachers, 'studentsCode' => $code_for_students), function($message) use ($school) {
                    $message->to($school->email, $school->school_name)->subject('Activate Your Account');
                });
                return Redirect::route('activate-account-create')
                                ->with('global', 'You have been Registered. You can activate Now.');
            } else {
                return Redirect::route('activate-account-create')
                                ->with('global', 'You have not Been Registered. Try Again Later Some time.');
            }
        }
    }

    public function getActivate($code) {

        $school = Schools::where('registration_code', '=', $code)->where('active', '=', 0);

        if ($school->count()) {
            $school = $school->first();

            $school->active = 1;

            if ($school->save()) {
                return Redirect::route('activate-account-create')
                                ->with('global', 'Activated thanks. You can login now');
            }
        }
        return Redirect::route('activate-account-create')
                        ->with('global', 'Cant activate do after some time');
    }

    public function getSchoolTest() {
        return View::make('admin.school-test');
    }

    public function postValidateSchoolForStudents() {
        $registration_code = Input::get('registration_code');
        $code_for_students = Input::get('code_for_students');

        $school = Schools::where('registration_code', '=', $registration_code)
                        ->where('code_for_students', '=', $code_for_students)->get()->first();

        if ($school->count() > 0) {

            $user = Sentry::getUser();
            $user->school_id = $school->id;
            $user->save();

            $users_login_info = new UsersLoginInfo();
            $users_login_info->user_id = $user->id;
            $users_login_info->school_id = $school->id;
            $users_login_info->save();

            $response = array(
                'status' => 'success',
                'msg' => 'Validation is Successfull',
                'result' => array(
                    'school' => $school
                )
            );
            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Validation is not Successfull',
                'result' => array(
                    'school' => null
                )
            );
            return Response::json($response);
        }
    }

    public function postGetSchoolCurrentSession() {
        $school_id = Sentry::getUser()->school_id();

        $school_session = SchoolSession::where('school_id', '=', $school_id)->
                where('current_session', '=', 1)
                ->get();
        $response = array(
            'status' => 'failed',
            'msg' => 'Validation is not Successfull',
            'result' => array(
                'school_session' => $school_session
            )
        );
        return Response::json($response);
    }

    public function postValidateSchoolForAdmin() {
        $registration_code = Input::get('registration_code');
        $code_for_admin = Input::get('code_for_admin');

        $school = Schools::where('registration_code', '=', $registration_code)
                        ->where('code_for_admin', '=', $code_for_admin)->get()->first();

        if ($school->count() > 0) {

            $user = Sentry::getUser();
            $user->school_id = $school->id;
            $user->save();

            $users_login_info = new UsersLoginInfo();
            $users_login_info->user_id = $user->id;
            $users_login_info->school_id = $school->id;
            $users_login_info->save();

            $response = array(
                'status' => 'success',
                'msg' => 'Validation is Successfull',
                'result' => array(
                    'school' => $school
                )
            );
            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Validation is not Successfull',
                'result' => array(
                    'school' => null
                )
            );
            return Response::json($response);
        }
    }

    public function postValidateSchool() {
        $registration_code = Input::get('registration_code');
        $group_id = Input::get('group_id');

        try {
            // Find the group using the group id
            $group = Sentry::findGroupById($group_id);
            // Get the group permissions
            $groupPermissions = $group->getPermissions();
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            echo 'Group does not exist.';
        }

        if ($group->count() > 0) {
            if ($group->id == 3) {

                $code_for_teachers = Input::get('code_for_teachers');
                $school = Schools::where('registration_code', '=', $registration_code)
                                ->where('code_for_teachers', '=', $code_for_teachers)->get()->first();
            } elseif ($group_id == 2) {
                
                $code_for_students = Input::get('code_for_students');
                $school = Schools::where('registration_code', '=', $registration_code)
                                ->where('code_for_students', '=', $code_for_students)->get()->first();
            } elseif ($group_id == 1) {
                
                $code_for_admin = Input::get('code_for_admin');
                $school = Schools::where('registration_code', '=', $registration_code)
                                ->where('code_for_admin', '=', $code_for_admin)->get()->first();
            }

            if ($school->count() > 0) {

                $user = Sentry::getUser();
                $user->school_id = $school->id;
                $user->save();

                $users_login_info = new UsersLoginInfo();
                $users_login_info->user_id = $user->id;
                $users_login_info->school_id = $school->id;
                $users_login_info->save();

                $response = array(
                    'status' => 'success',
                    'result' => array(
                        'school' => $school
                    )
                );
                return Response::json($response);
            } else {

                $response = array(
                    'status' => 'failed',
                    'result' => array(
                        'school' => null
                    )
                );
                return Response::json($response);
            }
        }
    }
    /**
     * Api for Brief Registration
     */
    public function postBriefRegistration(){

        $first_name = Input::get('first_name');
        $last_name = Input::get('last_name');
        $sex = Input::get('sex');

        $user_details = UserDetails::where('user_id', '=', Sentry::getUser()->id)->get()->first();

        $user_details->first_name = $first_name;
        $user_details->last_name = $last_name;
        $user_details->sex = $sex;

        if($user_details->save()){

            $response = array(
                'status' => 'success',
                'result' => array(
                    'details' => $user_details
                )
            );
            return Response::json($response);
        }else{

            $response = array(
                'status' => 'failed',
                'result' => array(
                    'details' => null
                )
            );
            return Response::json($response);
        }
    }

}
