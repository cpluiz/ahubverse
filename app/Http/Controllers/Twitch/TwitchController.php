<?php

namespace App\Http\Controllers\Twitch;

use App\Models\ExtConfig;
use http\Env\Response;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers;
use Psr\Http\Message\ResponseInterface;

class TwitchController extends \App\Http\Controllers\Controller{
    protected $apiKey = null;
    public function RequestTwitchkey(){
        $twitch_login = "https://id.twitch.tv/oauth2/token?client_id=".env('TWITCH_CLIENT_ID')."&client_secret=".env('TWITCH_SECRET')."&grant_type=client_credentials&scope=chat:read+chat:edit+channel:moderate+whispers:read+whispers:edit+channel_editor";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', $twitch_login, []);
        $statusCode = $response->getStatusCode();
        if($statusCode != 200){
            dd($statusCode, $response->getBody());
        }
        $this->apiKey = ExtConfig::where('config_name', '=', 'access_token')->first();
        if(!$this->apiKey) {
            $this->apiKey = new ExtConfig;
            $this->apiKey->config_name = 'access_token';
        }
        $this->apiKey->config_value = json_decode($response->getBody(), true)['access_token'];
        $this->apiKey->save();
    }
    public function GetUserList(){
        if(!$this->apiKey)
            $this->RequestTwitchkey();
        $endpoint = "https://api.twitch.tv/helix/users?login=alinktothehub";
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey->config_value,
                'Client-Id' => env('TWITCH_CLIENT_ID')
            ]
        ]);
        if($response->getStatusCode() == 200)
            return json_decode($response->getBody(), true);
    }

    public function GetUserIdByName($userName){
        return $this->GetChannelIdByName($userName);
    }

    public function GetChannelIdByName($channelName){
        $endpoint = "https://api.twitch.tv/helix/users?login=".$channelName;
        $response = $this->GETapiCall($endpoint);
        if($response->getStatusCode() == 200)
            return json_decode($response->getBody(), true)['data'][0]['id'];
        return null;
    }
    public function GetChannelNameByID($channelID){
        $endpoint = "https://api.twitch.tv/helix/users?id=".$channelID;
        $response = $this->GETapiCall($endpoint);
        if($response->getStatusCode() == 200)
            return json_decode($response->getBody(), true)['data'][0]['login'];
        return null;
    }

    protected function GETcall($endpoint) : ResponseInterface{
        $client = new \GuzzleHttp\Client();
        return $client->request('GET', $endpoint);
    }

    protected function GETapiCall($endpoint) : ResponseInterface {
        if(!$this->apiKey)
            $this->RequestTwitchkey();
        $client = new \GuzzleHttp\Client();
        return $client->request('GET', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey->config_value,
                'Client-Id' => env('TWITCH_CLIENT_ID')
            ]
        ]);
    }
    private function POSTapiCall($endpoint) : ResponseInterface{
        if(!$this->apiKey)
            $this->RequestTwitchkey();
        $client = new \GuzzleHttp\Client();
        return $client->request('POST', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiKey->config_value,
                'Client-Id' => env('TWITCH_CLIENT_ID')
            ]
        ]);
    }
}
