<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TwitchChannels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $channelName = $request->session()->get('channelName') ?? request()->query->get('channelName');
        $channelData = TwitchChannels::where('channel_name', '=', $channelName)->get();
        if(Count($channelData) > 0){
            request()->query->remove('channelName');
            $request->session()->put('channelName', $channelName);
            $request->session()->put('channelID', $channelData[0]->channel_id);
            $request->session()->save();
            return $next($request);
        }
        return redirect('/');
    }
}
