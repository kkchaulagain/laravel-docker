<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function handleError(Exception $e)
    {
        $code = $e->getCode();
        // check is valid code 
        if ($code < 100 || $code > 600) {
            $code = 500;
        }
        $traces = [];
        // get instanve of $e;
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            $code = 422;
            $traces = $e->validator->errors()->toArray();
        }
        return $this->errorResponse(
            $e->getMessage(),
            $traces,
            $code
        );
    }
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
        return response()->json($data, $code);
    }

    public function validHTTPStatusCode($code)
    {
        return ($code >= 200 && $code < 600) ? $code : 500;
    }
}
