<?php

namespace App\Helpers;

// use App\Service;
// use App\Termin;
// use App\Specialist;
// use App\Notification;
use Illuminate\Http\Request;

class Helper {

    public static function url($url = '')
    {
        $locale = Request::segment(1);
        if ($locale == "en")
            return url('en/' . $url);
        else
            return url($url);
    }
}