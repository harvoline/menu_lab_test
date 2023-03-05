<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserWeatherData;
use App\Services\OpenWeatherMapService;

class UserLiveWeatherController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, User $user, OpenWeatherMapService $open_map_service)
    {
        $status_code = 200;

        try {
            $weather_data = $open_map_service->getWeatherData($user->latitude, $user->longitude);

            if (!empty($weather_data)) {
                $weather = $weather_data['weather']['0']['main'] ?? 'Unknown';
                $desc = $weather_data['weather']['0']['desc'] ?? 'Unknown';

                UserWeatherData::create([
                    'user_id' => $user->id,
                    'type' => 'openmap',
                    'weather' => $weather,
                    'description' => $desc,
                ]);
            }

            return response()->json([
                "user_live_weather_data" => [
                    'created_at' => now(),
                    'type' => 'openmap',
                    'weather' => $weather,
                    'description' => $desc,
                ],
                "message" => "Success",
            ], $status_code);
        } catch (Throwable $th) {
            $status_code = 400;

            return response()->json([
                "user_live_weather_data" => null,
                "message" => $th->getMessage(),
            ], $status_code);
        }
    }
}
