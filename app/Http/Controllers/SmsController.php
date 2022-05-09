<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Facades\Vonage;

class SmsController extends Controller
{
    //
    public function index(){
//        Vonage::message()->send([
//            'to'=>'receiver',
//            'from'=>'sender',
//            'text'=>'Test Sms'
//        ]);
        $basic  = new \Vonage\Client\Credentials\Basic("5bbc9d3b", "B78150aWEBzY5Vpz");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("84869786015", 'sender', 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
    }
}
