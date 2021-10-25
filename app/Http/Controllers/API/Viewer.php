<?php

namespace App\Http\Controllers\API;

use App\Models\Viewers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;
use App\Http\Controllers\Twitch\TwitchController;

class Viewer extends TwitchController{
    public function SetAvatar($userId, $avatarId){
        $viewer = Viewers::where('user_id', '=', $userId)->first();
        if($viewer)
            $viewer->avatar_id = $avatarId;
        else
            $viewer = new Viewers(['user_id'=> $userId, 'avatar_id' => $avatarId]);
        $viewer->save();
        return response()->json([$viewer->avatar_id], 200);
    }
    public function GetAvatar($userId){
        $viewer = Viewers::where('user_id', '=', $userId)->first();
        if(!$viewer) {
            $viewer = new Viewers(['user_id' => $userId, 'avatar_id' => 1]);
            $viewer->save();
        }
        return response()->json(['avatar_id' => $viewer->avatar_id], 200);
    }
}
