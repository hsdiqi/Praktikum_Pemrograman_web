<?php 

namespace App\Traits;

trait ApiResponseFormatter
{
    public function apiResponse($code = 200, $message = 'Success',$data = [])
    {
        return json_encode([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}