<?php

namespace App\Services;

use GuzzleHttp\Client;

class SMS
{
    private static function getResponse($command, array $param)
    {
        $full_path = env('TEXTLOCAL_URL');
        $full_path .= $command.'/';
        $client   = new Client();
        $result  = $client->post($full_path, $param);
        $body    = json_decode($result->getBody());
        if($body->status != 'success') {
            if (isset($body->errors) && count($body->errors) > 0) {
                foreach ($body->errors as $error) {
                    throw new \Exception('TextLocal API returned an error: '. $error->message);
                }
            }
        }
        return $body;
    }

    public static function sendSms($phone_no, $message)
    {
        $username = env('TEXTLOCAL_USERNAME');
        $hash  = env('TEXTLOCAL_HASH');
        // Message details
        $numbers = $phone_no;
        $sender  = env('TEXT_LOCAL_SENDER', 'TXTLCL');
        $message = $message;
        $command = env('TEXT_LOCAL_COMMAND', 'send');
        // Requesting Params
        $params = [
            'form_params' => [
                'username'=> $username,
                'hash'    => $hash,
                'message' => $message,
                'sender'  => $sender,
                'numbers' => $numbers,
                'test'    => 0,
                ]
            ];
        return SMS::getResponse($command, $params);
    }
}