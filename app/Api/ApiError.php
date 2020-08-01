<?php

namespace App\Api;

class ApiError
{
    /**
     * Class for handling error
     */
    public static function errorMessage($message, $code){

        return[
            'data'=>[
            'msg'=> $message,
            'code'=> $code
            
            ]
        ];

    }

}