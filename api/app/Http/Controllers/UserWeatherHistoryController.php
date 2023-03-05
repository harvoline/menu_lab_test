<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserWeatherData;
use Illuminate\Http\Request;
use Throwable;

class UserWeatherHistoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user)
    {
        $status_code = 200;

        try {
            $user_weather_data = UserWeatherData::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                "user_weather_data" => $user_weather_data->toArray(),
                "message" => "Success",
            ], $status_code);
        } catch (Throwable $th) {
            $status_code = 400;

            return response()->json([
                "user_weather_data" => null,
                "message" => $th->getMessage(),
            ], $status_code);
        }
    }
}
