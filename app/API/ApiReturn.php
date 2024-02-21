<?php

namespace App\API;

class ApiReturn
{
    public static function data($message, $code, $validation=null, $content=null)
    {
        return [
            'message' => $message,
            'code' => $code,
            'validation' => $validation,
            'content' => $content,
        ];
    }
}
