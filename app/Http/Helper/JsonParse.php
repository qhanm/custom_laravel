<?php

namespace App\Http\Helper;

class JsonParse{

    /**
     * @param $code
     * @param $message
     * @param $data
     * @param $statusCode
     */

    public static function parse(){
        $params = func_get_args();

        if( is_array($params) && count($params) > 0 ){
            $code       = $params[0];
            $message    = $params[1] ?? '';
            $data       = $params[2] ?? '';
            $statusCode = $params[3] ?? '';

            try{
                return response()->json([
                    'code'      => $code,
                    'message'   => $message,
                    'data'      => $data,
                    'statusCode' => $statusCode,
                ], $statusCode);
            }catch(Exception $ex){
                return response()->json([
                    'code'      => 0,
                    'message'   => "Http Status Code not Found!",
                    'data'      => "",
                    'statusCode' => 404,
                ], 404);
            }
        }
    }

}