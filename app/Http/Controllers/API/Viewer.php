<?php

namespace App\Http\Controllers\API;

use App\Models\Viewers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;
use App\Http\Controllers\Twitch\TwitchController;

class Viewer extends TwitchController{
    public function SetAvatar($userName, $avatarId){
        $userId = $this->GetUserIdByName($userName);
        if($userId == null)
            return null;
        $viewer = Viewers::where('user_id', '=', $userId)->first();
        if($viewer)
            $viewer->avatar_id = $avatarId;
        else
            $viewer = new Viewers(['user_id'=> $userId, 'user_name'=> $userName, 'avatar_id' => $avatarId]);
        $viewer->save();
        return response()->json([$viewer->avatar_id], 200);
    }
    public function GetAvatar($userName){
        $userId = $this->GetUserIdByName($userName);
        if($userId == null)
            return null;
        $viewer = Viewers::where('user_id', '=', $userId)->first();
        if(!$viewer) {
            $viewer = new Viewers(['user_id' => $userId, 'user_name' => $userName, 'avatar_id' => 1]);
            $viewer->save();
        }
        return response()->json(['avatar_id' => $viewer->avatar_id], 200);
    }
}
