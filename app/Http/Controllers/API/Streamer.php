<?php

namespace App\Http\Controllers\API;

use App\Models\TwitchChannels;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;

class Streamer extends \App\Http\Controllers\Twitch\TwitchController {
    public function GetCreatorsList(){
        //$channels = TwitchChannels::all()->pluck('channel_name')->toArray();
        $response = $this->GETcall('https://raw.githubusercontent.com/aHub-Tech/twitch-bot-wildoverflow/main/twitch_bot/database/streamers.yml');
        $channels = explode("\n", str_replace("- ", "", $response->getBody()->getContents()));
        $channels = array_filter($channels,function($v) { return !is_null($v) && $v!= '""' && strlen($v) > 0; });
        return $channels;
    }
    public function GetFollowSuggestions($channelName){
        $channel = TwitchChannels::where('channel_name','=',$channelName)->first();
        if(!$channel)
            return response()->json("{error: 'channel not found'}", 404);
        $channels = array_diff($this->GetCreatorsList(), [$channelName]);
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
