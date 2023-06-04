<?php

declare(strict_types=1);

namespace App\Enums;

enum WeatherApiEnum: string
{
    case OPEN_WEATHER = 'OpenWeather';
    case WEATHERBIT = 'Weatherbit';
    case WEATHERAPI = 'Weatherapi';
}
