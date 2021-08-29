<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;

class Viewer extends \App\Http\Controllers\Controller{
    public function DebugViewerData(){
        dd(request()->all());
    }
}
