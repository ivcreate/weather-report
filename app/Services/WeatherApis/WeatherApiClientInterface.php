<?php

declare(strict_types=1);

namespace App\Services\WeatherApis;

use App\Services\WeatherApis\Response\Forecast\WeatherForecastApiCollection;

interface WeatherApiClientInterface
{
    public function forecast(int $countDays, string $location): WeatherForecastApiCollection;

    public function isRealLocation(string $location);
}
