<?php

namespace App\Services\Traits;

trait canRespond
{
    public function successResponse($data, $code = 200)
    {
        $response = [
            'data' => $data,
            'code' => $code

        ];
        return  $this->respond($response, $code);
    }

    public function errorResponse($message, $error = [], $code = 400)
    {
        $response = [
            'message' => $message,
            'error' => $error,
            'code' => $code

        ];

        return  $this->respond($response, $code);
    }

    public function respond($data, $code = 200)
    {
        $code = $this->validHTTPStatusCode($code);
        return response()->json($data, $code);
    }

    public function validHTTPStatusCode($code)
    {
        return ($code >= 200 && $code < 600) ? $code : 500;
    }
}
