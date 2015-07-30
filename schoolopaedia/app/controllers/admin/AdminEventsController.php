<?php

class AdminEventsController extends SchoolDetailsController {

    public function getSchoolEvents() {
        return View::make('admin.events');
    }

    public function getEventTypes(){
        return View::make('admin.event-types');
    }

    /**
     * Ajax Api for getting event types
     */
    public function postGetEventTypes() {

        $school_id = $this->getSchoolId();
        $event_types = EventTypes::where('school_id', '=', $school_id)->get();

        $result = array(
            'event_types' => $event_types,
        );
        $request = null;

        if(count($event_types) >= 0){
            $response = ApiResponseClass::successResponse($result, $request);
        }else{
            $response = ApiResponseClass::errorResponse("Invalid_Request", "Cant fetch Event Types.", $request);
        }

        return $response;
    }

    /**
     * Ajax Api for getting event types
     */
    public function postCreateEvent() {

        $title = Input::get('title');
        $start = Input::get('start');
        $end = Input::get('end');
        $allDay = Input::get('allDay');
        $category = Input::get('category');
        $content = Input::get('content');
        $school_id = $this->getSchoolId();

        if ($allDay == "true") {
            $allDay = 1;
        } else {
            $allDay = 0;
        }

        $event = new Events();
        $event->title = $title;
        $event->start = date($start);
        $event->end = date($end);
        $event->allday = $allDay;
        $event->category = $category;
        $event->content = $content;
        $event->school_id = $school_id;

        if ($event->save()) {

            $response = array(
                'status' => 'Success',
                'result' => array(
                    'events' => $event,
                )
            );

            return Response::json($response);
        } else {

            $response = array(
                'status' => 'Failed',
                'result' => array(
                    'events' => 'none',
                )
            );

            return Response::json($response);
        }
    }

    public function postGetEvent() {

        $school_id = $this->getSchoolId();

        $all_events = Events::where('school_id', '=', $school_id)->get();

        $i = 0;
        foreach ($all_events as $all_event) {
            $event_type_name = EventTypes::where('id', '=', $all_event->category)->get()->first();
            $all_events[$i++]['category'] = $event_type_name->event_type_name;
        }

        return Response::json($all_events);
    }

    /**
     * @return json
     */
    public function postSaveEventType(){

        $request = [
            'event_type_id' => Input::get('event_type_id'),
            'event_type_name' => Input::get('event_type_name')
        ];

        if($request['event_type_id']){
            $event_type = EventTypes::find($request['event_type_id']);
        }else{
            $event_type = new EventTypes();
        }
        $event_type->event_type_name = $request['event_type_name'];
        $event_type->school_id = $this->getSchoolId();

        if($event_type->save()){
            $response = ApiResponseClass::successResponse($event_type, $request);
        }else{
            $response = ApiResponseClass::errorResponse('Not Saved', 'Event Type Not saved.', $request);
        }

        return $response;
    }

    public function postDeleteEventTypes(){

        $request = [
          'event_type_id' => Input::get('event_type_id')
        ];

        $event_type = EventTypes::find($request['event_type_id']);

        if($event_type->delete()){
            $response = ApiResponseClass::successResponse($event_type, $request);
        }else{
            $response = ApiResponseClass::errorResponse('Not Deleted', 'Event Type Not Deleted.', $request);
        }

        return $response;

    }


}
