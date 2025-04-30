<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($message, $code, $validation = null, $content = null)
    {
        $response = [
            'message' => $message,
            'code' => $code,
            'validation' => $validation,
            'content' => $content
        ];

        return response()->json($response, 200);
    }
}
