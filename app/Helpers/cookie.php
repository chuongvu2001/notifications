<?php

use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Cookie;

if (!function_exists('setCookiee')) {
    function setCookiee($code)
    {
        $minutes = 60;
        $response = new Response($code);
        $response->withCookie(cookie('name', $code, $minutes));

        return $response;
    }
}

if (!function_exists('getCookiee')) {
    function getCookiee($request)
    {
        $value = $request->cookie('name');
//        $value = Cookie::get('code');
        echo $value;
    }
}
