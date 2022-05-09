<?php

namespace App\Services\Helpers;

use Vonage\Client\Credentials\Basic;
use Vonage\Client;
use Vonage\Client\Exception\Request as VonageExceptionRequest;
use Illuminate\Support\Facades\Log;

class VonageService
{
    public static function send($phoneNumber, $code, $content, $from = null)
    {
        $to = $phoneNumber;
        $from = getenv('TWILIO_FROM');
        $message = 'Your activate code is: ' . $code;
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, getenv('TWILIO_SID') . ':' . getenv('TWILIO_TOKEN'));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_URL, sprintf('https://api.twilio.com/2010-04-01/Accounts/'
            . getenv('TWILIO_SID') . '/Messages.json', getenv('TWILIO_SID')));
        curl_setopt($ch, CURLOPT_POST, 3);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'To=' . $to . '&From=' . $from . '&Body=' . $message);

        //execute post
        $result = curl_exec($ch);
        $result = json_decode($result);

        //close connection
//        curl_close($ch);

        return $code;

//        $basic = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
//        $client = new Client($basic);
//
//        try {
//
//            $response = $client->sms()->send(
//                new \Vonage\SMS\Message\SMS($phoneNumber, env('VONAGE_FROM_SEND'), $content)
//            );
//
//            $message = $response->current();
//            if ($message->getStatus() == 0) {
//                echo "The message was sent successfully\n";
//            } else {
//                echo "The message failed with status: " . $message->getStatus() . "\n";
//            }
//        } catch (VonageExceptionRequest $e) {
//            Log::error($e); //Nexmo error
//        }

//        throw new \Exception('Vonage send sms code error', 200);
    }

    public static function generateRandomString($length = 6)
    {
        return substr(sha1(rand()), 0, $length);
    }
}


