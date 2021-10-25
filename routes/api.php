<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Streamer;
use App\Http\Controllers\API\Viewer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/creators', [Streamer::class, 'GetCreatorsList'])->name('creators');
Route::get('/suggestions/{channelName}', [Streamer::class, 'GetFollowSuggestions'])->name('suggestions');
Route::get('/chatters/{channelName}', [Streamer::class, 'GetActiveUsers'])->name('chatters');
Route::get('/setAvatar/{userId}/{avatarId}', [Viewer::class, 'SetAvatar'])->name('set_avatar');
Route::get('/getAvatar/{userId}', [Viewer::class, 'GetAvatar'])->name('get_avatar');
Route::get('/suggestion/{channelName}/{suggestion}', [Streamer::class, 'CheckSuggestion'])->name('can_suggest');

