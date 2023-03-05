<?php

namespace App\Console\Commands;

use App\Models\UserWeatherData;
use Throwable;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\OpenWeatherMapService;

class GetWeatherFromAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather from API';

    /**
     * Execute the console command.
     */
    public function handle(OpenWeatherMapService $open_map_service, User $user_model): void
    {
        $users = $user_model::all()->toArray();
        foreach ($users as $user) {
            $weather_data = [];
            try {
                echo "(User {$user['id']}) Weather fetch - Start" . PHP_EOL;
                $weather_data = $open_map_service->getWeatherData($user['latitude'], $user['longitude']);
            } catch (Throwable $th) {
                Log::error($th->getMessage());
                Log::error($th->getLine());
            }

            if (!empty($weather_data)) {
                $weather = $weather_data['weather']['0']['main'] ?? 'Unknown';
                $desc = $weather_data['weather']['0']['desc'] ?? 'Unknown';

                echo "(User {$user['id']}) Weather fetch - Saving" . PHP_EOL;
                UserWeatherData::create([
                    'user_id' => $user['id'],
                    'type' => 'openmap',
                    'weather' => $weather,
                    'description' => $desc,
                ]);
            }

            echo "(User {$user['id']}) Weather fetch - Done" . PHP_EOL;
        }
    }
}
