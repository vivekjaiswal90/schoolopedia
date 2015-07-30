<?php
/**
 * Description of AdminAccountController
 *
 * @author 1084760
 */

class AdminAccountController  extends BaseController {

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

    public function getAdminProfile(){
        $user = Sentry::getUser();
        $user_details = UserDetails::where('user_id', '=', $user->id)->get()->first();
        
        return View::make('admin.profile')->with('user', $user)->with('user_details', $user_details);
    }

    public function postEdit(){
        
        $pic_New_Name = NULL;
        if(Input::hasFile('pic')){
            
        $file = Input::file('pic');  
        $new_path = 'assets\projects\images\profilepics';     
        $file_Temporary_name = $file->getFilename();            // emporary file name
        $file_OriginalName = $file->getClientOriginalName();  // Original Name of the file
        $file_Size = $file->getClientSize();          // Size of the file
        $file_MimeType = $file->getClientMimeType();      // Mime Type of the file
        $file_Extension = $file->guessClientExtension();   // Ext of the file
        $file_TemporaryPath = $file->getRealPath();            // Temporary file path
        
        $pic_New_Name = md5(date('Y-m-d H:i:s:u')).".".$file_Extension;
         
        $uploaded = $file->move($new_path, $pic_New_Name);  
        }
        
        //$pic = Image::make($file)->resize(300,150)->save($new_path.$file_OriginalName);
        $validator = Validator::make(Input::all(),
            array(
                'first_name'            => 'max:30',
                'last_name'             => 'max:30',
                'mobile_number'         => 'max:10',
                'home_number'           => 'max:10',
                'dd'                    => 'max:2',
                'mm'                    => 'max:2',
                'yyyy'                  => 'max:4',
                'add_1'                 => 'max:30',
                'city'                  => 'max:30',
                'state'                 => 'max:30',
                'pin_code'              => 'max:10',
                'country'               => 'max:30'
            )
        );
        if($validator->fails()){
            return Redirect::route('admin-profile')
                ->withErrors($validator)
                ->withInput();
        }else{
            
            $user = $this->getUser();
            $user_details = UserDetails::where('user_id', '=', $user->id)->get()->first();
            
            $now                              = date("Y-m-d H-i-s");
            
            $user_details->first_name                 = Input::get('first_name');
            $user_details->middle_name                = Input::get('middle_name');
            $user_details->last_name                  = Input::get('last_name');
            
            if($user_details->mobile_number != Input::get('mobile_number')){
              $user_details->mobile_number              = Input::get('mobile_number');
              $user_details->mobile_updated_at          = $now;
            }
            
            $user_details->home_number                = Input::get('home_number');
            
            $user_details->dob                        = Input::get('yyyy')."-".Input::get('mm')."-".Input::get('dd');
            $user_details->sex                        = Input::get('sex');
            $user_details->marriage_status            = Input::get('marriage_status');
            
            if(($user_details->add_1 != Input::get('add_1')) || ($user_details->add_2 != Input::get('add_2'))){
              $user_details->add_1                      = Input::get('add_1');
              $user_details->add_2                      = Input::get('add_2');
              $user_details->address_updated_at         = $now;
            }
            
            if(($user_details->city != Input::get('city')) || ($user_details->state != Input::get('state')) || ($user_details->pin_code != Input::get('pin_code')) || ($user_details->country != Input::get('country'))){
            
              $user_details->city                       = Input::get('city');
              $user_details->state                      = Input::get('state');
              $user_details->pin_code                   = Input::get('pin_code');
              $user_details->country                    = Input::get('country');
              $user_details->address_updated_at         = $now;
            }
            
            if(isset($pic_New_Name)){
              $user_details->pic                        = $pic_New_Name;
              $user_details->pic_updated_at             = $now;
            }
                
            if($user_details->save()){
                return Redirect::route('admin-profile')->with('details-changed', 'Your Details are updated');
            }else{
                return Redirect::route('admin-profile')->with('details-not-changed', 'Your Details Couldnt updated. Some Error Occured');
            }

        }
    }

    public function postChangePassword(){
        
            $updated = false;
        
            $user = User::find(Auth::user()->id);
            
            $now       =    date("Y-m-d H-i-s");
              
            if($user->email != Input::get('email')){

                  $updated = true;
                
                  $validator = Validator::make(Input::all(), array('email'  => 'sometimes|max:60|email|unique:users' ));
                  if($validator->fails()){
                         return Redirect::route('admin-profile')->withErrors($validator)->withInput();
                  }else{
                         $user->email                      = Input::get('email');
                         $user->email_updated_at           = $now;
                  }
            }

            $auth = Auth::attempt(array('password' => Input::get('old_password')));
                      
            if($auth){
                if(Input::get('password') != NULL){

                        $updated = true;
                
                        $validator = Validator::make(Input::all(),
                                     array(
                                             'password'       => 'required|min:3',
                                             'password_again' => 'required|same:password'
                                          )
                                    );
                        if($validator->fails()){
                                    return Redirect::route('admin-profile')->withErrors($validator);
                        }else{
                                    $user->password                 =  Hash::make(Input::get('password'));
                                    $user->password_updated_at      =  $now;
                        }
                }                
            }else{
                    return Redirect::route('admin-profile')->with('details-not-changed', 'Your Current Password is not matched. Try Again');
            }
            
            if($updated){
                if($user->save()){
                    return Redirect::route('admin-profile')->with('details-changed', ' Your Details are Changed');
                }else{
                    return Redirect::route('admin-profile')->with('details-not-changed', 'Your details Not Changed . Try Again');
                }
            }else{
                    return Redirect::route('admin-profile')->with('details-not-changed', ' You didn\'t changed any details. Check and Try Again');
            }
    }

    public function postForgotPassword(){
        $validator = Validator::make(Input::all(),
            array(
                'email' => 'required|email'
            )
        );
        if($validator->fails()){
            return Redirect::route('admin-forgot-password')
                ->withErrors($validator)
                ->withInput();
        }else{
            $user = User::where('email' , '=', Input::get('email'));

            if($user->count()) {
                $user = $user->first();
            }else{
                return Redirect::route('admin-forgot-password')->with('global', 'No such Email in our database. Enter Correct Email of yours');
            }

            //generate code and password

            $code                 = str_random(60);
            $password_temp        = str_random(10);

            $user->code           = $code;
            $user->password_temp  = Hash::make($password_temp);

            if($user->save()){
                //send email
                Mail::send('emails.auth.recover', array('link' => URL::route('admin-account-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user){
                    $message->to($user->email, $user->username)->subject('Change Password for Your Account');
                });
                return Redirect::route('admin-sign-in')->with('global', 'We have sent the Password to ur email. Check Your Email Account for directions.');
            }
        }
        return Redirect::route('account-forgot-password')->with('global', 'Password could Not Changed . Try Again');
    }

    public function getRecover($code){
        $user = User::where('code', '=', $code)
        ->where('password_temp', '!=', '');

        if($user->count()){
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->password_temp = '';
            $user->code =  '';

            if($user->save()){
                return Redirect::route('admin-sign-in')
                    ->with('global', 'We have changed your password to new one.');
            }

            return Redirect::route('account-forgot-password')
                ->with('global', 'Password could Not Changed . Try Again');
        }
    }

}
