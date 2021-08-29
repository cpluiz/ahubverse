<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Twitch\TwitchController;
use App\Models\TwitchChannels;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class TwitchChannelController extends TwitchController{
    public function __construct(){
        $this->middleware('auth');
    }

    public function list()
    {
        $channels = TwitchChannels::all();
        return view('admin.twitch_list', compact('channels'));
    }

    public function editChannel(int $id){
        $channel = TwitchChannels::find($id);
        $users = User::all();
        if(!$channel)
            $channel = new TwitchChannels;
        return view('admin.twitch_edit', compact('channel', 'users'));
    }

    public function updateChannel(int $id){
        $channel = TwitchChannels::find($id);
        if(!$channel)
            $channel = new TwitchChannels;
        if(TwitchChannels::all()->count() > 1)
            $this->validate(
                request(),
                [
                    'channel_name' => 'required|unique:twitch_channels,channel_name,'.$id,
                    'user_id' => 'required|unique:twitch_channels,user_id,'.$id,
                    'follow_suggestions' => 'sometimes|nullable',
                    'ignore_users' => 'sometimes|nullable'
                ]
            );
        $channel->fill(request()->all());
        $channel->channel_name = mb_strtolower($channel->channel_name);
        if(!$channel->channel_id)
            $channel->channel_id = $this->GetChannelIdByName(mb_strtolower($channel->channel_name));
        $channel->save();
        return $this->list();
    }
}
