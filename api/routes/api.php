<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetAllUsersController;
use App\Http\Controllers\UserLiveWeatherController;
use App\Http\Controllers\UserWeatherHistoryController;

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

Route::get('/', function () {
    $mode = "cache";
    $users = Redis::get('users');

    if (!$users) {
        $users = User::all();
        Redis::set('users', $users);
        $mode = "model";
    }

    return response()->json([
        'message' => 'all systems are a go',
        'users' => json_decode($users),
        'mode' => $mode,
    ]);
});

Route::get('/user/{user}/weather', UserWeatherHistoryController::class)->name('users.all');
Route::get('/user/{user}/live_weather', UserLiveWeatherController::class)->name('users.all');
