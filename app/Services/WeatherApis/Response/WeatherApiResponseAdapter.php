<?php

declare(strict_types=1);

namespace App\Services\WeatherApis\Response;

use App\Services\WeatherApis\Response\Forecast\WeatherForecastApiCollection;
use App\Services\WeatherApis\Response\Forecast\WeatherForecastApiItem;

class WeatherApiResponseAdapter
{
    public static function weatherapiAdapter(array $weatherApiResponses): WeatherForecastApiCollection
    {
        $weatherForecastApiCollection = new WeatherForecastApiCollection();
        //здесь можно добавить больше нужных данных
        foreach ($weatherApiResponses as $weatherApiResponse) {
            foreach ($weatherApiResponse['hour'] as $hour) {
                $weatherForecastApiCollection->addItem(new WeatherForecastApiItem(new \DateTimeImmutable($hour['time']), $hour['temp_c']));
            }
        }

        return $weatherForecastApiCollection;
    }
}
