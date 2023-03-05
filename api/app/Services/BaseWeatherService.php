<?php

namespace App\Services;

abstract class BaseWeatherService
{
    abstract public function getWeatherData(float $lat, float $long): Array;
}
