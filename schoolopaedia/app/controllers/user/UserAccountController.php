<?php

/**
 * Created by PhpStorm.
 * User: summmmit
 * Date: 2/11/2015
 * Time: 1:47 AM
 */
class UserAccountController extends BaseController {

    public function getCreate() {
        return View::make('user.account.register');
    }

    public function postCreate() {

        $validator = Validator::make(Input::all(), array(
                    'first_name' => 'required|max:30',
                    'last_name' => 'required|max:30',
                    'city' => 'required|max:30',
                    'state' => 'required|max:30',
                    'sex' => 'required',
                    'school_registration_code' => 'required|max:80',
                    'user_registration_code' => 'required|max:80',
                    'email' => 'max:60|email|unique:users',
                    'password' => 'required|min:6',
                    'password_again' => 'required|same:password',
                        )
        );

        if ($validator->fails()) {
            return Redirect::route('user-account-create')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $school_registration_code = Input::get('school_registration_code');
            $user_registration_code = Input::get('user_registration_code');

            $school = Schools::where('registration_code', '=', $school_registration_code)
                    ->where('code_for_students', '=', $user_registration_code)
                    ->where('active', '=', 1)
                    ->get();

            if (!$school->count()) {
                return Redirect::route('admin-account-create')
                                ->with('global', 'Please input Correct School code and Admin Code.');
            }

            $first_name = Input::get('first_name');
            $last_name = Input::get('last_name');
            $email = Input::get('email');
            $sex = Input::get('sex');
            $city = Input::get('city');
            $state = Input::get('state');
            $password = Input::get('password');

            // Unique Username
            $username = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1, 10))), 1, 10);

            //Activation Code
            $code = str_random(60);

            $now = date("Y-m-d H-i-s");

            $groups = Groups::find(1);

            $User = User::create(array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'email_updated_at' => $now,
                        'password' => Hash::make($password),
                        'password_updated_at' => $now,
                        'username' => $username,
                        'sex' => $sex,
                        'city' => $city,
                        'state' => $state,
                        'address_updated_at' => $now,
                        'code' => $code,
                        'active' => 0,
                        'mobile_verified' => 0,
                        'permissions' => $groups->id,
                        'school_id' => $school->first()->id
            ));

            if ($User) {

                //send email
                Mail::send('emails.auth.activate.activate-user', array('link' => URL::route('user-account-activate', $code), 'username' => $username), function($message) use ($User) {
                    $message->to($User->email, $User->voter_id)->subject('Activate Your Account');
                });
                return Redirect::route('user-sign-in')
                                ->with('global', 'You have been Registered. You can activate Now.');
            } else {
                return Redirect::route('user-sign-in')
                                ->with('global', 'You have not Been Registered. Try Again Later Some time.');
            }
        }
    }

    public function getActivate($code) {

        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if ($user->count()) {
            $user = $user->first();

            //update user

            $user->active = 1;
            $user->code = "";

            if ($user->save()) {
                return Redirect::route('user-sign-in')
                                ->with('global', 'Activted thanks');
            }
        }
        return Redirect::route('user-sign-in')
                        ->with('global', 'Cant activate do after some time');
    }

    public function getSignIn() {
        return View::make('user.account.login');
    }

    public function postSignIn() {
        $validator = Validator::make(Input::all(), array(
                    'email' => 'required',
                    'password' => 'required'
                        )
        );
        if ($validator->fails()) {
            return Redirect::route('user-sign-in')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt(array(
                        'email' => Input::get('email'),
                        'password' => Input::get('password'),
                        'permissions' => 1
                            ), $remember);

            if ($auth) {

                $active = Auth::user()->active;

                if ($active == 0) {
                    Auth::logout();
                    return Redirect::route('user-sign-in')->with('global', 'Account Not Activated. Activate it.');
                } else if ($active == 1) {
                    //log into the users_login_info table

                    $prev_user_info = UsersLoginInfo::where('user_id', '=', Auth::user()->id)->get();

                    if ($prev_user_info->count() == 0) {   //if count is 0 then send to set initial sessions page
                        $user_info = new UsersLoginInfo();
                        $user_info->user_id = Auth::user()->id;
                        $user_info->school_id = Auth::user()->school_id;
                        // other properties according to the ip
                        $user_info->save();

                        return Redirect::intended('/user/class/set/intial');
                    } else {

                        $user_info = new UsersLoginInfo();
                        $user_info->user_id = Auth::user()->id;
                        $user_info->school_id = Auth::user()->school_id;
                        // other properties according to the ip
                        $user_info->save();

                        return Redirect::intended('/user/home');
                    }
                }
            } else {

                return Redirect::route('user-sign-in')
                                ->with('global', 'Email Address or Password Wrong');
            }
        }

        return Redirect::route('user-sign-in')->with('global', 'account not activated');
    }
    
    public function getSetInitial(){
        $session = SchoolSession::where('school_id', '=', Sentry::getUser()->school_id)->orderBy('session_start', 'desc')->get()->first();
        $streams = Streams::where('school_id', '=',Sentry::getUser()->school_id)->get();
        
        return View::make('user.initial-school-settings')->with('session', $session)->with('streams', $streams);
    }

    public function getSignOut() {
        Auth::logout();
        return Redirect::route('user-sign-in')->with('global', 'You Have Been Successfully Signed Out');
    }

    public function getUserHome() {
        return View::make('user.user-home');
    }

    public function getUserProfile() {
        $user = Sentry::getUser();
        $user_details = UserDetails::where('user_id', '=', $user->id)->get()->first();
        return View::make('user.profile')->withuser($user)->with('user_details', $user_details);
    }

    public function postEdit() {

        $pic_New_Name = NULL;
        if (Input::hasFile('pic')) {

            $file = Input::file('pic');
            $new_path = 'assets\projects\images\profilepics';
            $file_Temporary_name = $file->getFilename();            // emporary file name
            $file_OriginalName = $file->getClientOriginalName();  // Original Name of the file
            $file_Size = $file->getClientSize();          // Size of the file
            $file_MimeType = $file->getClientMimeType();      // Mime Type of the file
            $file_Extension = $file->guessClientExtension();   // Ext of the file
            $file_TemporaryPath = $file->getRealPath();            // Temporary file path

            $pic_New_Name = md5(date('Y-m-d H:i:s:u')) . "." . $file_Extension;

            $uploaded = $file->move($new_path, $pic_New_Name);
        }

        //$pic = Image::make($file)->resize(300,150)->save($new_path.$file_OriginalName);
        $validator = Validator::make(Input::all(), array(
                    'first_name' => 'max:30',
                    'last_name' => 'max:30',
                    'mobile_number' => 'max:10',
                    'home_number' => 'max:10',
                    'dd' => 'max:2',
                    'mm' => 'max:2',
                    'yyyy' => 'max:4',
                    'relative_id' => 'max:30',
                    'add_1' => 'max:30',
                    'city' => 'max:30',
                    'state' => 'max:30',
                    'pin_code' => 'max:10',
                    'country' => 'max:30'
                        )
        );
        if ($validator->fails()) {
            return Redirect::route('user-profile')
                            ->withErrors($validator)
                            ->withInput();
        } else {

            $user = User::find(Sentry::getUser()->id);

            $now = date("Y-m-d H-i-s");

            $user->first_name = Input::get('first_name');
            $user->middle_name = Input::get('middle_name');
            $user->last_name = Input::get('last_name');

            if ($user->mobile_number != Input::get('mobile_number')) {
                $user->mobile_number = Input::get('mobile_number');
                $user->mobile_updated_at = $now;
            }

            $user->home_number = Input::get('home_number');

            $user->dob = Input::get('yyyy') . "-" . Input::get('mm') . "-" . Input::get('dd');
            $user->sex = Input::get('sex');
            $user->marriage_status = Input::get('marriage_status');
            $user->relative_id = Input::get('relative_id');
            $user->relation_with_person = Input::get('relation_with_person');

            if (($user->add_1 != Input::get('add_1')) || ($user->add_2 != Input::get('add_2'))) {
                $user->add_1 = Input::get('add_1');
                $user->add_2 = Input::get('add_2');
                $user->address_updated_at = $now;
            }

            if (($user->city != Input::get('city')) || ($user->state != Input::get('state')) || ($user->pin_code != Input::get('pin_code')) || ($user->country != Input::get('country'))) {

                $user->city = Input::get('city');
                $user->state = Input::get('state');
                $user->pin_code = Input::get('pin_code');
                $user->country = Input::get('country');
                $user->address_updated_at = $now;
            }

            if (isset($pic_New_Name)) {
                $user->pic = $pic_New_Name;
                $user->pic_updated_at = $now;
            }

            if ($user->save()) {
                return Redirect::route('user-profile')->with('details-changed', 'Your Details are updated');
            } else {
                return Redirect::route('user-profile')->with('details-not-changed', 'Your Details Couldnt updated. Some Error Occured');
            }
        }
    }

    public function postChangePassword() {

        $updated = false;

        $user = User::find(Auth::user()->id);

        $now = date("Y-m-d H-i-s");

        if ($user->email != Input::get('email')) {

            $updated = true;

            $validator = Validator::make(Input::all(), array('email' => 'sometimes|max:60|email|unique:users'));
            if ($validator->fails()) {
                return Redirect::route('user-profile')->withErrors($validator)->withInput();
            } else {
                $user->email = Input::get('email');
                $user->email_updated_at = $now;
            }
        }

        $auth = Auth::attempt(array('password' => Input::get('old_password')));

        if ($auth) {
            if (Input::get('password') != NULL) {

                $updated = true;

                $validator = Validator::make(Input::all(), array(
                            'password' => 'required|min:3',
                            'password_again' => 'required|same:password'
                                )
                );
                if ($validator->fails()) {
                    return Redirect::route('user-profile')->withErrors($validator);
                } else {
                    $user->password = Hash::make(Input::get('password'));
                    $user->password_updated_at = $now;
                }
            }
        } else {
            return Redirect::route('user-profile')->with('details-not-changed', 'Your Current Password is not matched. Try Again');
        }

        if ($updated) {
            if ($user->save()) {
                return Redirect::route('user-profile')->with('details-changed', ' Your Details are Changed');
            } else {
                return Redirect::route('user-profile')->with('details-not-changed', 'Your details Not Changed . Try Again');
            }
        } else {
            return Redirect::route('user-profile')->with('details-not-changed', ' You didn\'t changed any details. Check and Try Again');
        }
    }

    public function getForgotPassword() {
        return View::make('user.account.forgot-password');
    }

    public function postForgotPassword() {
        $validator = Validator::make(Input::all(), array(
                    'email' => 'required|email'
                        )
        );
        if ($validator->fails()) {
            return Redirect::route('user-forgot-password')
                            ->withErrors($validator)
                            ->withInput();
        } else {
            $user = User::where('email', '=', Input::get('email'));

            if ($user->count()) {
                $user = $user->first();
            } else {
                return Redirect::route('user-forgot-password')->with('global', 'No such Email in our database. Enter Correct Email of yours');
            }

            //generate code and password

            $code = str_random(60);
            $password_temp = str_random(10);

            $user->code = $code;
            $user->password_temp = Hash::make($password_temp);

            if ($user->save()) {
                //send email
                Mail::send('emails.auth.recover', array('link' => URL::route('user-account-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user) {
                    $message->to($user->email, $user->username)->subject('Change Password for Your Account');
                });
                return Redirect::route('user-sign-in')->with('global', 'We have sent the Password to ur email. Check Your Email Account for directions.');
            }
        }
        return Redirect::route('account-forgot-password')->with('global', 'Password could Not Changed . Try Again');
    }

    public function getRecover($code) {
        $user = User::where('code', '=', $code)
                ->where('password_temp', '!=', '');

        if ($user->count()) {
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code = '';

            if ($user->save()) {
                return Redirect::route('user-sign-in')
                                ->with('global', 'We have changed your password to new one.');
            }

            return Redirect::route('account-forgot-password')
                            ->with('global', 'Password could Not Changed . Try Again');
        }
    }

}
