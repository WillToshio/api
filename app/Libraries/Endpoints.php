<?php

namespace App\Libraries;


class Endpoints {

    public function getTest($endpoint){

        helper('url');

        $start = microtime(true);

        $ch = curl_init(base_url($endpoint));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);

        $responseBody = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error      = curl_error($ch);

        curl_close($ch);

        $timeMs = round((microtime(true) - $start) * 1000);

        $validJson = false;

        if($statusCode === 200 && $responseBody !== false){
            $decoded = json_decode($responseBody, true);
            $validJson = json_last_error() === JSON_ERROR_NONE && is_array($decoded);
        }

        return [
            'body' => $responseBody,
            'status' => $statusCode,
            'error'  => $error ?: null,
            'valid_response' => $validJson,
            'time'   => $timeMs
        ];
    }
}