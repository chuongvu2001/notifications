<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmController extends Controller
{
    //
    public function index()
    {
        return view('firebase');
    }

    public function sendNotification()
    {
        $token = "cgDcP4F-xv4:APA91bFNRUmDbM7WFwTEwe2R_KY8IHFGucsOoslRRZaTZjeVwTZ6ne2nCqPbiRIIQXFnIxeS7XEJsG0T_u1YKx5Yv3jnTpJWosXuqzGPA9JoX6s_raAIJKwNe8tV_nBmBPN5Oqn9I8l6";
        $from = "AAAAvmtdNQk:APA91bEFYJyFmqo7cZacGIVU6N0It12Gs3zp44sfhWexQJJoJsMEngXvQ6dwhh5K-TzV3yLuCE__r3z2pKDNznBwPiVKcDO6VXJSnXrGTwyy142G0pw76xBZGTU_ZJge7MHRXFlpqhsN";
        $msg = array
        (
            'body' => "Chun",
            'title' => "Hi, From Raj",
            'receiver' => 'erw',
            'icon' => "https://image.flaticon.com/icons/png/512/270/270014.png",/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );

        $fields = array
        (
            'to' => $token,
            'notification' => $msg
        );

        $headers = array
        (
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        dd($result);
        curl_close($ch);
    }
}
