<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendEmailNotification;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    //
    public function sendNotification()
    {
        $users = User::all();

        $details = [
            'greeting' => Str::random(10),
            'body' => Str::random(15),
            'actiontext' => Str::random(30),
            'actionurl' => '/',
            'lastline' => Str::random(5),
        ];

        Notification::send($users, new SendEmailNotification($details));

        dd('done');
    }
}
