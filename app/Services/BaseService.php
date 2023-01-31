<?php

namespace App\Services;

abstract class BaseService
{


    public function sendRequest($method, $url, $data = [], $token = "")
    {
        $headers = array();
        $headers[] = 'Content-type: application/json';
        $headers[] = 'Authorization: ' . $token;
        $headers[] = 'Content-Length: ' .  strlen(json_encode($data));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        //status code

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            $headers
        );
        $result = curl_exec($ch);
        curl_close($ch);
        //get status code
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return [
            'status_code' => $status_code,
            'body' => $result
        ];
    }
}
