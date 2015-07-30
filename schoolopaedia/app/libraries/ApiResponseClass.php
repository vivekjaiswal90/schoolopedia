<?php

class ApiResponseClass {
    
    public static function  successResponse($result = array(), $request = array()){
        
        $successResponse = [
            'status'   => 'success',
            'result'   =>  $result,
            'request'  =>  $request
        ];

        //return json_encode($successResponse, 200);
        return Response::json($successResponse, 200);
    }
    
    public static function errorResponse($message, $description, $request = array()){
        
        $errorResponse = [
            'status'    => 'failed',
            'error'     => [
                'message'      =>  $message,
                'description'  =>  $description
            ],
            'request'   => $request
        ];
        return Response::json($errorResponse, 200);
    }
}
