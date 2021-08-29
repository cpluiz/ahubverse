<?php

namespace App\Http\Controllers\API;

use App\Models\TwitchChannels;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;

class Streamer extends \App\Http\Controllers\Twitch\TwitchController {
    public function GetCreatorsList(){
        $channels = TwitchChannels::all()->pluck('channel_name')->toArray();
        return response()->json("{creators: '.$channels.'}", 200);
    }
    public function GetFollowSuggestions($channelName){
        $channel = TwitchChannels::where('channel_name','=',$channelName)->first();
        if(!$channel)
            return response()->json("{error: 'channel not found'}", 404);
        $channels = TwitchChannels::where('channel_name', "!=", $channelName)->pluck('channel_name')->toArray();
        $suggestions = json_decode($channel->follow_suggestions);
        return response()->json([
            'suggestions' => array_merge($channels, $suggestions),
            'ignoreUsers' => json_decode($channel->ignore_users)
        ], 200);
    }
    public function GetActiveUsers($channelName){
        $endpoint = "https://tmi.twitch.tv/group/user/".$channelName."/chatters";
        $response = $this->GETapiCall($endpoint);
        if($response->getStatusCode() == 200)
            return json_decode($response->getBody(), true);
        return null;
    }
}
