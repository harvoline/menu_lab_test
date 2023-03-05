<?php

namespace App\Services;

use Throwable;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenWeatherMapService extends BaseWeatherService
{
    private $client;

    public function __construct()
    {
        $this->app_id = env('OPEN_WEATHER_APP_ID', '69f04e4613056b159c2761a9d9e664d2');
        $this->client = new Client();
    }

    public function getWeatherData(float $lat, float $long): Array
    {
        $weather_data = [];

        $api_url = "https://api.openweathermap.org/data/2.5/weather";

        try {
            $response = $this->client->request('GET', $api_url, [
                "query" => [
                    "appid" => $this->app_id,
                    "lat" => $lat,
                    "lon" => $long,
                ],
            ]);

            $weather_data = json_decode($response->getBody()->getContents(), true);
        } catch (Throwable $th) {
            print_r($th->getMessage());
            print_r($th->getLine());
            Log::error($th->getMessage());
            Log::error($th->getLine());
        }

        return $weather_data;
    }
}
