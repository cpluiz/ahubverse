<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('/creators', [App\Http\Controllers\API\Streamer::class, 'GetCreatorsList'])->name('creators');
Route::get('/suggestions/{channelName}', [App\Http\Controllers\API\Streamer::class, 'GetFollowSuggestions'])->name('suggestions');
Route::get('/chatters/{channelName}', [App\Http\Controllers\API\Streamer::class, 'GetActiveUsers'])->name('chatters');
Route::post('/debug', [App\Http\Controllers\API\Viewer::class, 'DebugViewerData'])->name('debug');

