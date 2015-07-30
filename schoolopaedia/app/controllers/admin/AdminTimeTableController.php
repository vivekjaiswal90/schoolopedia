<?php

/**
 * Description of AdminAccountController
 *
 * @author 1084760
 */
class AdminTimeTableController extends BaseController {

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

    public function getTimeTableCreate() {
        $classes = Classes::where('school_id', '=', $this->getSchoolId())->get();
        $streams = Streams::where('school_id', '=', $this->getSchoolId())->get();
        return View::make('admin.time-table-set')->with('classes', $classes)->with('streams', $streams);
    }

    public function postGetClasses() {
        $classes = Classes::where('school_id', '=', $this->getSchoolId())->get();

        $response = array(
            'status' => 'success',
            'msg' => 'Classes fetched successfully',
            'errors' => null,
            'classes' => $classes
        );

        return Response::json($response);
    }

    public function postAddClasses() {

        $validator = Validator::make(Input::all(), array(
                    'class_name' => 'required|max:30|min:3',
                    'stream_id' => 'required'
        ));

        if ($validator->fails()) {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is not updated',
                'errors' => $validator->failed(),
                'error_messages' => $validator->messages()
            );

            return Response::json($response);
        } else {

            $new_class = Input::get('class_name');
            $class_id = Input::get('class_id');
            $streams_id = Input::get('stream_id');

            $streams_name = Streams::find($streams_id)->stream_name;

            if ($class_id) {

                $classes = Classes::find($class_id);
                $classes->class = $new_class;
                $classes->streams_id = $streams_id;
                $classes->school_id = $this->getSchoolId();

                if ($classes->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Setting created successfully',
                        'errors' => null,
                        'data_send' => array(
                            'id' => $classes->id,
                            'class_name' => $classes->class,
                            'streams_id' => $classes->streams_id,
                            'streams_name' => $streams_name,
                        ),
                    );

                    return Response::json($response);
                }
            } else {

                $classes = new Classes();
                $classes->class = $new_class;
                $classes->streams_id = $streams_id;
                $classes->school_id = $this->getSchoolId();

                if ($classes->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Setting created successfully',
                        'errors' => null,
                        'data_send' => array(
                            'id' => $classes->id,
                            'class_name' => $classes->class,
                            'streams_id' => $classes->streams_id,
                            'streams_name' => $streams_name,
                        ),
                    );

                    return Response::json($response);
                }
            }
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Item is not updated'
        );

        return Response::json($response);
    }

    public function postDeleteClasses() {

        $stream_id = Input::get('stream_id');
        $class_id = Input::get('class_id');
        $class_name = Input::get('class_name');


        if ($class_id) {
            $classes = Classes::find($class_id);
        } else {
            $classes = Classes::where('class', '=', $class_name)->where('streams_id', '=', $stream_id);
        }

        if ($classes->delete()) {

            $response = array(
                'status' => 'success',
                'msg' => 'Updated successfully',
                'deleted_class_id' => $class_id,
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is Not deleted',
                'Item_id' => $class_id,
            );

            return Response::json($response);
        }
    }

    public function postGetStreams() {

        $streams = Streams::where('school_id', '=', $this->getSchoolId())->get();

        $response = array(
            'status' => 'success',
            'result' => array(
                'streams' => $streams
            )
        );

        return Response::json($response);
    }

    public function postAddStreams() {

        $validator = Validator::make(Input::all(), array(
                    'stream_name' => 'required|max:30|min:3'
        ));

        if ($validator->fails()) {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is not updated',
                'errors' => $validator,
                'error_messages' => $validator->messages()
            );

            return Response::json($response);
        } else {

            $new_stream = Input::get('stream_name');
            $new_stream_id = Input::get('stream_id');

            if ($new_stream_id) {

                $streams = Streams::find($new_stream_id);
                $streams->stream_name = ucwords($new_stream);

                if ($streams->save()) {

                    $response = array(
                        'status' => 'success',
                        'data_send' => array(
                            'id' => $streams->id,
                            'inserted_item' => $streams->stream_name
                        ),
                    );

                    return Response::json($response);
                }
            } else {

                $streams = new Streams();
                $streams->stream_name = ucfirst($new_stream);
                $streams->school_id = $this->getSchoolId();

                if ($streams->save()) {

                    $response = array(
                        'status' => 'success',
                        'data_send' => array(
                            'id' => $streams->id,
                            'inserted_item' => $streams->stream_name
                        ),
                    );

                    return Response::json($response);
                }
            }
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Item is not updated'
        );

        return Response::json($response);
    }

    public function postDeleteStreams() {

        $new_stream = Input::get('stream_id');
        $stream_name = Input::get('stream_name');


        if ($new_stream) {
            $streams = Streams::find($new_stream);
        } else {
            $streams = Streams::where('stream_name', '=', $stream_name);
        }

        $classes = Classes::where('streams_id', '=', $streams->id)->get();

        if ($streams->delete()) {

            foreach ($classes as $class) {
                Classes::find($class->id)->delete();
            }

            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
                'deleted_item_id' => $new_stream,
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is Not deleted',
                'Item_id' => $new_stream,
            );

            return Response::json($response);
        }
    }

    public function postGetSections() {

        $class_id = Input::get('class_id');

        $sections = Sections::where('class_id', '=', $class_id)->get();


        $response = array(
            'status' => 'success',
            'result' => array(
                'sections' => $sections
            )
        );

        return Response::json($response);
    }

    public function postAddSections() {

        $validator = Validator::make(Input::all(), array(
                    'section_name' => 'required|max:30|min:3'
        ));

        if ($validator->fails()) {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is not updated',
                'errors' => $validator,
                'error_messages' => $validator->messages()
            );

            return Response::json($response);
        } else {

            $section_name = Input::get('section_name');
            $section_id = Input::get('section_id');
            $class_id = Input::get('class_id');

            if ($section_id) {
                $section = Sections::find($section_id);
                $section->section_name = ucwords($section_name);

                if ($section->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Setting created successfully',
                        'errors' => null,
                        'data_send' => array(
                            'id' => $section->id,
                            'section_name' => $section->section_name
                        ),
                    );

                    return Response::json($response);
                }
            } else {

                $section = new Sections();
                $section->section_name = ucwords($section_name);
                $section->class_id = $class_id;

                if ($section->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Setting created successfully',
                        'errors' => null,
                        'data_send' => array(
                            'id' => $section->id,
                            'section_name' => $section->section_name
                        ),
                    );

                    return Response::json($response);
                }
            }
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Item is not updated'
        );

        return Response::json($response);
    }

    public function postDeleteSections() {

        $section_id = Input::get('section_id');
        $section_name = Input::get('section_name');
        $class_id = Input::get('class_id');


        if ($section_id) {
            $sections = Sections::find($section_id);
        } else {
            $sections = Sections::where('section_name', '=', $section_name)->where('class_id', '=', $class_id);
        }

        if ($sections->delete()) {

            $response = array(
                'status' => 'success',
                'msg' => 'Setting created successfully',
                'deleted_item_id' => $section_id,
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is Not deleted',
                'Item_id' => $section_id,
            );

            return Response::json($response);
        }
    }

    public function postGetSubjects() {

        $classId = Input::get('class_id');
        $sectionId = Input::get('section_id');

        $subjects = Subjects::where('class_id', '=', $classId)->where('section_id', '=', $sectionId)->get();

        $response = array(
            'status' => 'success',
            'msg' => 'Subjects got successfully',
            'result' => array(
                'subjects' => $subjects
            )
        );

        return Response::json($response);
    }

    public function postAddSubjects() {

        $validator = Validator::make(Input::all(), array(
                    'subject_name' => 'required|max:30|min:3',
                    'subject_code' => 'required|max:30|min:2'
        ));

        if ($validator->fails()) {

            $response = array(
                'status' => 'failed',
                'msg' => 'Item is not updated',
                'errors' => $validator,
                'error_messages' => $validator->messages()
            );

            return Response::json($response);
        } else {

            $subject_id = Input::get('subject_id');
            $subject_name = Input::get('subject_name');
            $subject_code = Input::get('subject_code');
            $class_id = Input::get('class_id');
            $section_id = Input::get('section_id');

            if ($subject_id) {
                $subjects = Subjects::find($subject_id);
                $subjects->subject_name = ucwords($subject_name);
                $subjects->subject_code = strtoupper($subject_code);

                if ($subjects->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Subjects created successfully',
                        'errors' => null,
                        'result' => array(
                            'subjects' => $subjects
                        ),
                    );

                    return Response::json($response);
                }
            } else {

                $subjects = new Subjects();
                $subjects->subject_name = ucwords($subject_name);
                $subjects->subject_code = strtoupper($subject_code);
                $subjects->class_id = $class_id;
                $subjects->section_id = $section_id;

                if ($subjects->save()) {

                    $response = array(
                        'status' => 'success',
                        'msg' => 'Setting created successfully',
                        'errors' => null,
                        'result' => array(
                            'subjects' => $subjects
                        ),
                    );

                    return Response::json($response);
                }
            }
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'Item is not updated'
        );

        return Response::json($response);
    }

    public function postDeleteSubjects() {

        $class_id = Input::get('class_id');
        $section_id = Input::get('section_id');
        $subject_id = Input::get('subject_id');
        $subject_name = Input::get('subject_name');
        $subject_code = Input::get('subject_code');


        if ($subject_id) {
            $subjects = Subjects::find($subject_id);
        } else {
            $subjects = Subjects::where('subject_name', '=', $subject_name)
                    ->where('subject_code', '=', $subject_code)
                    ->where('class_id', '=', $class_id)
                    ->where('section_id', '=', $section_id);
        }

        if ($subjects->delete()) {

            $response = array(
                'status' => 'success',
                'msg' => 'Subject deleted successfully',
                'result' => array(
                    'subjects' => $subjects,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Subject is Not deleted',
                'result' => array(
                    'subjects' => $subjects,
                )
            );

            return Response::json($response);
        }
    }

    public function postGetClassStreamPair() {
        $classes = Classes::where('school_id', '=', $this->getSchoolId())->orderBy('class', 'asc')->get();

        $i = 0;
        $stream_Class_Pairs = array();
        foreach ($classes as $class => $value) {
            $stream = Streams::find($classes[$class]['streams_id']);
            $stream_Class_Pairs[$i] = array(
                'classes_id' => $classes[$class]['id'],
                'streams_id' => $classes[$class]['streams_id'],
                'stream_class_pair' => $classes[$class]['class'] . " (" . $stream->stream_name . ")"
            );
            $i++;
        }

        $response = array(
            'status' => 'success',
            'result' => array(
                'stream_class_pairs' => $stream_Class_Pairs,
            ),
        );

        return Response::json($response);
    }

    public function getCreateTimeTable() {
        $weekDays = Config::get('constants.weekDays');

        return View::make('admin.admin-create-time-table')->with('weekDays', $weekDays);
    }

    public function postGetTimeTablePeriods() {
        
        $class_id = Input::get('class_id');
        $section_id = Input::get('section_id');
        $day_id = Input::get('day_id');
        $timetables = Timetable::where('class_id', '=', $class_id)
                                ->where('section_id', '=', $section_id)
                                ->where('day_id', '=', $day_id)->get();

        $timetable_periods = array();
        $i = 0;
        foreach ($timetables as $timetable) {
            $subject = Subjects::find($timetable->subject_id);
            $teacher = UserDetails::find($timetable->users_id);
            $period  = Periods::find($timetable->period_id);
            $timetable_periods[$i] = array(
                'timetable_period' => $timetable,
                'subject' => $subject,
                'teacher' => $teacher,
                'period'  => $period
            );
            $i++;
        }

        $response = array(
            'status' => 'success',
            'msg' => 'Setting created successfully',
            'result' => array(
                'timetable_periods' => $timetable_periods
            )
        );

        return Response::json($response);
    }

    public function postAddTimeTablePeriods() {

        $period_id = Input::get('period_id');
        $class_id = Input::get('class_id');
        $day_id = Input::get('day_id');
        $section_id = Input::get('section_id');
        $subject_id = Input::get('subject_id');
        $teacher_id = Input::get('teacher_id');

        $timetable_period_id = Input::get('timetable_period_id');

        if ($timetable_period_id) {
            $timetable_period = Timetable::find($timetable_period_id);
        } else {
            $timetable_period = new Timetable();
        }

        $timetable_period->period_id = $period_id;
        $timetable_period->class_id = $class_id;
        $timetable_period->subject_id = $subject_id;
        $timetable_period->day_id = $day_id;
        $timetable_period->section_id = $section_id;
        $timetable_period->users_id = $teacher_id;


        $subject = Subjects::find($subject_id);
        $teacher = UserDetails::find($teacher_id);
        $period = Periods::find($period_id);

        if ($timetable_period->save()) {

            $response = array(
                'status' => 'success',
                'msg' => 'New Timetable period is saved, Successfully',
                'result' => array(
                    'period' => $period,
                    'subject' => $subject,
                    'teacher' => $teacher,
                    'timetable_period' => $timetable_period
                )
            );

            return Response::json($response);
        }

        $response = array(
            'status' => 'failed',
            'msg' => 'New Timetable period Couldnt be saved',
            'result' => array(
                'timetable_period' => 'none'
            )
        );

        return Response::json($response);
    }

    public function postDeletePeriods() {

        $period_id = Input::get('period_id');
        $class_id = Input::get('class_id');
        $day_id = Input::get('day_id');
        $section_id = Input::get('section_id');
        $subject_id = Input::get('subject_id');
        $teacher_id = Input::get('teacher_id');

        if ($period_id) {
            $period = Timetable::find($period_id);
        } else {
            $period = Timetable::where('section_id', '=', $section_id)->where('class_id', '=', $class_id)->where('subject_id', '=', $subject_id)->where('users_id', '=', $teacher_id)->where('day_id', '=', $day_id);
        }

        if ($period->delete()) {

            $response = array(
                'status' => 'success',
                'msg' => 'Timetable Period deleted successfully',
                'result' => array(
                    'period' => $period,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'failed',
                'msg' => 'Timetable Period could not be deleted successfully',
                'result' => array(
                    'period' => $period,
                )
            );

            return Response::json($response);
        }
    }

    public function postGetTeachers() {

        $query = "SELECT * 
                     FROM  `users` 
                     JOIN users_groups
                     ON users.id = users_groups.user_id
                     JOIN user_details
                     ON users.id = user_details.user_id
                     AND users_groups.groups_id = ?
                     AND users.school_id = ?
                ";
        $teachers = DB::select($query, array(3, $this->getSchoolId()));

        $response = array(
            'status' => 'success',
            'result' => array(
                'teachers' => $teachers
            )
        );

        return Response::json($response);
    }

}
