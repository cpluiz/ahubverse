<?php

namespace App\Http\Controllers\Twitch;

use App\Models\ExtConfig;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;

class StreamerController extends TwitchController {
    public function ShowAvatarOnBrowser(){
        return view('frontend.unity.avatar_interface');
    }
}
