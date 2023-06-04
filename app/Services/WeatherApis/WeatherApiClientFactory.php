<?php

declare(strict_types=1);

namespace App\Services\WeatherApis;

use App\Enums\WeatherApiEnum;

class WeatherApiClientFactory
{
    public static function create(WeatherApiEnum $weatherApiEnum): WeatherApiClientInterface
    {
        switch ($weatherApiEnum) {
            case WeatherApiEnum::OPEN_WEATHER:
                return new WeatherapiClient();
            case WeatherApiEnum::WEATHERAPI:
                return new WeatherapiClient();
            case WeatherApiEnum::WEATHERBIT:
                return new WeatherapiClient();
            default:
                throw new \InvalidArgumentException('Invalid weather API specified.');
        }
    }
}
