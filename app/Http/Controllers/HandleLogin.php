<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HandleLogin extends Controller{
    public function HandleTwitchLogin(){
        $code = request()->query('code');
        return view('frontend.token_code', compact('code'));
    }
}
