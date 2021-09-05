<?php

namespace App\Http\Controllers\API;

use App\Models\LastSuggestion;
use App\Models\TwitchChannels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;
use \App\Http\Controllers\Twitch\TwitchController;

class Streamer extends TwitchController {
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
        $suggestions = json_decode($channel->follow_suggestions);
        $channels = array_merge(array_diff($this->GetCreatorsList(), [$channelName]),$suggestions);
        $ignore = json_decode($channel->ignore_users)
        array_walk($channels, function(&$value){
            $value = strtolower($value);
        });
        array_walk($ignore, function(&$value){
            $value = strtolower($value);
        });
        return response()->json([
            'suggestions' => $channels,
            'ignoreUsers' => $ignore
        ], 200);
    }

    public function CheckSuggestion($channelName, $suggestion){
        $fromChannelId = $this->GetUserIdByName($channelName);
        if(!TwitchChannels::where('channel_id', '=', $fromChannelId))
            return response()->json(['message' => 'Channel ID not registered on this system'], 406);
        $lastSuggested = LastSuggestion::where('from_channel_user_id', '=', $fromChannelId)->where('to_channel_name', '=', $suggestion)->first();
        if(!$lastSuggested) {
            $lastSuggested = new LastSuggestion([
                'from_channel_user_id' => $fromChannelId,
                'to_channel_name' => $suggestion,
                'last_suggestion' => Carbon::now()
            ]);
            $lastSuggested->save();
            return response()->json([
                'followCommand' => true
            ], 200);
        }else{
            $canSuggest = $lastSuggested->last_suggestion->diffInSeconds(Carbon::now()) > (3 * 60 * 60);
            if($canSuggest) {
                $lastSuggested->last_suggestion = Carbon::now();
                $lastSuggested->save();
            }
            return response()->json([
                'followCommand' => $canSuggest
            ], 200);
        }
    }

    public function GetActiveUsers($channelName){
        $endpoint = "https://tmi.twitch.tv/group/user/".$channelName."/chatters";
        $response = $this->GETapiCall($endpoint);
        if($response->getStatusCode() == 200)
            return json_decode($response->getBody(), true);
        return null;
    }
}
