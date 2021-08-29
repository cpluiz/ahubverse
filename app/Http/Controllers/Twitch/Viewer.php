<?php

namespace App\Http\Controllers\Twitch;

use App\Models\ExtConfig;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;

class Viewer extends TwitchController {
    public function TestTwitchIntegration(){
        dd($this->GetUserList());
    }
}
