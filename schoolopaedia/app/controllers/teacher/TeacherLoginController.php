<?php

class TeacherLoginController extends BaseController
{

    //Show register Form
    public function getCreate()
    {
        return View::make('teacher.account.register');
    }

    public function postCreate()
    {

        $validator = Validator::make(Input::all(), array(
                'email' => 'max:60|email|unique:users',
                'password' => 'required|min:6',
                'password_again' => 'required|same:password',
            )
        );

        if ($validator->fails()) {
            return Redirect::route('teacher-account-create')
                ->withErrors($validator)
                ->withInput();
        } else {

            try {

                $email = Input::get('email');
                $password = Input::get('password');

                //Pre activate user
                //$user = Sentry::register(array('email' => $email, 'password' => $password), true);
                //$user = Sentry::register(array('email' => $input['email'], 'password' => $input['password']));

                $user = Sentry::createUser(array(
                    'email' => $email,
                    'password' => $password,
                    'activated' => 0,
                    'email_updated_at' => date("Y-m-d h:i:s"),
                    'password_updated_at' => date("Y-m-d h:i:s"),
                ));


                //Get the activation code & prep data for email
                $activationCode = $user->GetActivationCode();
                $userId = $user->getId();

                //send email with link to activate.
                /*Mail::send('emails.register_confirm', $data, function($m) use ($data) {
                 $m -> to($data['email']) -> subject('Thanks for Registration - Support Team');
                 });*/

                //If no groups created then create new groups
                try {
                    $user_group = Sentry::findGroupById(3);
                } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                    $this->createGroup('administrator');
                    $this->createGroup('students');
                    $this->createGroup('teacher');
                    $user_group = Sentry::findGroupById(3);
                }

                $user->addGroup($user_group);

                $userDetails = new UserDetails();

                $userDetails->user_id = $userId;
                $userDetails->save();

                //send email
                Mail::send('emails.auth.activate.activate-admin', array('link' => URL::route('admin-account-activate', $activationCode), 'activationCode' => $activationCode, 'userId' => $userId, 'email' => $email), function ($message) use ($user) {
                    $message->to($user->email)->subject('Activate Your Account');
                });

                //success!
                Session::flash('global', 'Thanks for sign up . Please activate your account by clicking activation link in your email');
                return Redirect::to(route('teacher-account-create'));

            } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                Session::flash('global', 'Email Required.');
                return Redirect::to(route('teacher-account-create'))->withErrors($validator)->withInput(Input::except(array('password', 'password_again')));
            } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
                Session::flash('global', 'User Already Exist.');
                return Redirect::to(route('teacher-account-create'))->withErrors($validator)->withInput(Input::except(array('password', 'password_again')));
            }

        }
    }

    public function createGroup($groupName)
    {
        $input = array('newGroup' => $groupName);

        // Set Validation Rules
        $rules = array('newGroup' => 'required|min:4');

        //Run input validation
        $v = Validator::make($input, $rules);

        if ($v->fails()) {
            return false;
        } else {
            try {
                $group = Sentry::getGroupProvider()->create(array('name' => $input['newGroup'], 'permissions' => array('admin' => Input::get('adminPermissions', 0), 'users' => Input::get('userPermissions', 0),),));

                if ($group) {
                    return true;
                } else {
                    return false;
                }

            } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
                return false;
            } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
                return false;
            }
        }
    }

    public function getActivate($userId, $activationCode)
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($userId);

            // Attempt to activate the user
            if ($user->attemptActivation($activationCode)) {
                Session::flash('global', 'User Activation Successfull Please login below.');
                return Redirect::to(route('teacher-sign-in'));
            } else {
                Session::flash('global', 'Unable to activate user Try again later or contact Support Team.');
                return Redirect::to(route('teacher-account-create'));
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('global', 'User was not found.');
            return Redirect::to(route('teacher-account-create'));
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            Session::flash('global', 'User is already activated.');
            return Redirect::to(route('teacher-account-create'));
        }
    }

    public function getSignIn()
    {
        return View::make('teacher.account.login');
    }

    //Authenticate User
    public function postSignIn()
    {

        $inputs = array('identity' => Input::get('identity'), 'password' => Input::get('password'));
        //Since user can enter username,email we cannot have email validator
        $rules = array('identity' => 'required|min:4|max:32', 'password' => 'required|min:6');

        //Find is that username or password and change identity validation rules
        //Lets use regular expressions
        if (filter_var(Input::get('identity'), FILTER_VALIDATE_EMAIL)) {
            //It is email
            $rules['identity'] = 'required|min:4|max:32|email';
        } else {
            //It is username . Check if username exist in profile table
            if (UserDetails::where('username', Input::get('identity'))->count() > 0) {
                //User exist so get email address
                $user = UserDetails::where('username', Input::get('identity'))->first();
                $inputs['identity'] = $user->email;

            } else {
                Session::flash('global', 'User does not exist');
                return Redirect::to(route('teacher-sign-in'))->withInput(Input::except('password'));
            }
        }

        $v = Validator::make($inputs, $rules);

        if ($v->fails()) {
            return Redirect::to(route('teacher-sign-in'))->withErrors($v)->withInput(Input::except('password'));
        } else {
            try {
                //Try to authenticate user
                $user = Sentry::getUserProvider()->findByLogin(Input::get('identity'));

                $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

                $throttle->check();

                //Authenticate user
                $credentials = array('email' => Input::get('identity'), 'password' => Input::get('password'));

                //For now auto activate users
                $user = Sentry::authenticate($credentials, false);

                //At this point we may get many exceptions lets handle all user management and throttle exceptions
            } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                Session::flash('global', 'Login field is required.');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
                Session::flash('global', 'Password field is required.');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
                Session::flash('global', 'Wrong password, try again.');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Session::flash('global', 'User was not found.');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                Session::flash('global', 'User is not activated.');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
                Session::flash('global', 'User is suspended ');
                return Redirect::to(route('teacher-sign-in'));
            } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
                Session::flash('global', 'User is banned.');
                return Redirect::to(route('teacher-sign-in'));
            }

            //    $users_login_info = UsersLoginInfo::where('user_id', '=', $user->id)->get();


            Session::flash('global', 'Loggedin Successfully');

            if ($user->school_id != null && $user->last_login != null) {
                $school_id = $user->school_id;

                $users_login_info = new UsersLoginInfo();
                $users_login_info->user_id = $user->id;
                $users_login_info->school_id = $school_id;

                if ($users_login_info->save()) {
                    Session::flash('global', 'Loggedin Successfully.');
                    return Redirect::to(route('teacher-home'));
                }

            } else {
                return Redirect::to(route('teacher-welcome-settings'));
            }
        }

    }

    //this is the code for facebook Login
    public function getFacebookLogin($auth = NULL)
    {
        if ($auth == 'auth') {
            try {
                Hybrid_Endpoint::process();
            } catch (Exception $e) {
                return Redirect::to('fbauth');
            }
            return;
        }
        try {
            // create a HybridAuth object
            $socialAuth = new Hybrid_Auth(app_path() . '/config/packages/hybridauth/fbauth.php');
            // authenticate with Google
            $provider = $socialAuth->authenticate("Facebook");
            // fetch user profile
            $userProfile = $provider->getUserProfile();
        } catch (Exception $e) {
            // exception codes can be found on HybBridAuth's web site
            return $e->getMessage();
        }
        // access user profile data
        echo "Connected with: <b>{$provider->id}</b><br />";
        echo "As: <b>{$userProfile->displayName}</b><br />";
        echo "<pre>" . print_r($userProfile, true) . "</pre><br />";

        // logout
        //$provider->logout();
    }

    //this is the method that will handle the Google Login
    public function getGoogleLogin($auth = NULL)
    {
        if ($auth == 'auth') {
            Hybrid_Endpoint::process();

        }
        try {
            $oauth = new Hybrid_Auth(app_path() . '/config/packages/hybridauth/gauth.php');
            $provider = $oauth->authenticate('Google');
            $profile = $provider->getUserProfile();
        } catch (exception $e) {
            return $e->getMessage();
        }


        echo "<pre>";
        print_r($profile);
        echo "</pre><br />";

        return $profile->email . '<a href="logout">Log Out</a>';

    }

    public function loginWithSocial($social_provider, $action = "")
    {
        // check URL segment
        if ($action == "auth") {

            // process authentication
            try {
                Session::set('provider', $social_provider);
                Hybrid_Endpoint::process();
            } catch (Exception $e) {
                // redirect back to http://URL/social/
                return Redirect::route('loginWith');
            }
            return;
        }

        try {
            // create a HybridAuth object
            $socialAuth = new Hybrid_Auth(app_path() . '/config/hybridauth.php');
            // authenticate with Provider
            $provider = $socialAuth->authenticate($social_provider);

            // fetch user profile
            $userProfile = $provider->getUserProfile();

            print_r($userProfile);
            die;
        } catch (Exception $e) {
            // exception codes can be found on HybBridAuth's web site
            Session::flash('error_msg', $e->getMessage());
            return Redirect::to('/login');
        }

        $this->createOAuthProfile($userProfile);

        return Redirect::to('/');
    }

    public function createOAuthProfile($userProfile)
    {

        if (isset($userProfile->username)) {
            $username = strlen($userProfile->username) > 0 ? $userProfile->username : "";
        }

        if (isset($userProfile->screen_name)) {
            $username = strlen($userProfile->screen_name) > 0 ? $userProfile->screen_name : "";
        }

        if (isset($userProfile->displayName)) {
            $username = strlen($userProfile->displayName) > 0 ? $userProfile->displayName : "";
        }

        $email = strlen($userProfile->email) > 0 ? $userProfile->email : "";
        $email = strlen($userProfile->emailVerified) > 0 ? $userProfile->emailVerified : "";

        $password = $this->generatePassword();

        if (Profile::where('email', $email)->count() <= 0) {
            $user = Sentry::register(array('email' => $email, 'password' => $password), true);

            try {
                $user_group = Sentry::findGroupById(1);
            } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                $this->createGroup('users');
                $this->createGroup('admin');
                $user_group = Sentry::findGroupById(1);
            }

            $user->addGroup($user_group);

            $profile = new Profile();

            $profile->user_id = $user->getId();
            $profile->email = $email;
            $profile->username = $username;
            $profile->save();
        }
        //Login user
        //Try to authenticate user
        try {
            $user = Sentry::findUserByLogin($email);

            $throttle = Sentry::getThrottleProvider()->findByUserId($user->id);

            $throttle->check();

            //Authenticate user
            $credentials = array('email' => $email, 'password' => Input::get('password'));

            Sentry::login($user, false);

            //At this point we may get many exceptions lets handle all user management and throttle exceptions
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('error_msg', 'Login field is required.');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('error_msg', 'Password field is required.');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            Session::flash('error_msg', 'Wrong password, try again.');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('error_msg', 'User was not found.');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            Session::flash('error_msg', 'User is not activated.');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            Session::flash('error_msg', 'User is suspended ');
            return Redirect::to('/login');
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            Session::flash('error_msg', 'User is banned.');
            return Redirect::to('/login');
        }

    }

    public function getForgotPassword()
    {
        return View::make('teacher.account.forgot-password');
    }

    public function postForgotPassword()
    {

        if (Input::has('email')) {
            $email = Input::get('email');

            try {
                // Find the user using the user email address
                $user = Sentry::findUserByLogin($email);

                // Get the password reset code
                $resetCode = $user->getResetPasswordCode();

                Mail::send("emails.auth.recover", array("email" => $email, "resetCode" => $resetCode), function ($message) use ($email, $resetCode) {
                    $message->to($email)->subject('Follow the link to reset your password');
                });

                Session::flash('global', 'We have sent a link to your email account please follow that to reset your password');
                return Redirect::to(route('teacher-forgot-password'));

                // Now you can send this code to your user via email for example.
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Session::flash('global', 'User not found');
                return Redirect::to(route('teacher-forgot-password'));
            }
        } else {
            Session::flash('global', 'User not found');
            return Redirect::to(route('teacher-forgot-password'));
        }
    }

    public function getResetPassword()
    {
        if (Input::has('email') && Input::has('resetcode')) {

            try {
                // Find the user using the user id
                $user = Sentry::findUserByLogin(Input::get('email'));

                // Check if the reset password code is valid
                if ($user->checkResetPasswordCode(Input::get('resetcode'))) {
                    return View::make('teacher.account.reset-password');

                } else {
                    Session::flash('global', 'Invalid request . Please enter email to reset your password');
                    return Redirect::to('/forgot/password');
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Session::flash('global', 'User not found');
                return Redirect::to('/forgot/password');
            }
        } else {
            Session::flash('global', 'Invalid request . Please enter email to reset your password');
            return Redirect::to('/forgot/password');
        }
    }

    public function postStoreNewPassword()
    {
        //Validator to check password ,password confirmation
        $input = array('password' => Input::get('password'), 'password_confirmation' => Input::get('password_again'));

        $rules = array('password' => 'required|min:4|max:32|confirmed', 'password_confirmation' => 'required|min:4|max:32');

        $v = Validator::make($input, $rules);

        if ($v->passes()) {
            if (Input::has('email') && Input::has('resetcode')) {

                try {
                    // Find the user using the user id
                    $user = Sentry::findUserByLogin(Input::get('email'));

                    // Check if the reset password code is valid
                    if ($user->checkResetPasswordCode(Input::get('resetcode'))) {
                        // Attempt to reset the user password
                        if ($user->attemptResetPassword(Input::get('resetcode'), Input::get('password'))) {
                            Session::flash('global', 'Password changed successfully . Please login below');
                            return Redirect::to(route('teacher-sign-in'));
                        } else {
                            Session::flash('global', 'Unable to reset password . Please try again');
                            return Redirect::to(route('teacher-forgot-password'));
                        }
                    } else {
                        Session::flash('global', 'Unable to reset password . Please try again');
                        return Redirect::to(route('teacher-forgot-password'));
                    }
                } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                    Session::flash('global', 'User not found');
                    return Redirect::to(route('teacher-forgot-password'));
                }
            } else {
                Session::flash('global', 'Invalid request . Please enter email to reset your password');
                return Redirect::to(route('teacher-forgot-password'));
            }
        } else {
            return Redirect::to(route('teacher-reset-password').'?email=' . Input::get('email') . '&resetcode=' . Input::get('resetcode'))->withErrors($v)->withInput();
        }
    }

    public function getSignOut()
    {
        Sentry::logout();
        return Redirect::to(route('teacher-sign-in'));
    }

    public function getWelcomeSettings()
    {
        return View::make('teacher.welcome-settings');
    }

    public function getTeacherHome()
    {
        return View::make('teacher.home');
    }

    // for the school sessions
    public function getSchoolSessions()
    {
        $session = SchoolSession::where('school_id', '=', Sentry::getUser()->school_id)
                                ->where('current_session', '=', 1)->get()->first();

        return View::make('teacher.initial-school-settings')->with('session', $session);
    }
    
    public function postSetSchoolSessions(){
        
        $session_id = Input::get('session_id');
        
        $user = Sentry::getUser();
        
        $users_to_session = new UsersRegisteredToSession();
        $users_to_session->school_session_id = $session_id;
        $users_to_session->school_id = $user->school_id;
        $users_to_session->user_id = $user->id;
        
        if($users_to_session->save()){
            return Redirect::route('teacher-home')->with('global', 'You Have Been Successfully Registered for this session');
        }else{
            return Redirect::route('teacher-school-set-sessions')->with('global', 'You can not be registered this time. Please Try later.');
        }
    }
}
