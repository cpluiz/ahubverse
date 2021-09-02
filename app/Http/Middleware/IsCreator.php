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
        if(Count(TwitchChannels::where('channel_name', '=', request()->query->get('channelName'))->get()) > 0)
            return $next($request);
        return redirect('/');
    }
}
