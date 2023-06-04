<?php

namespace App\Services\WeatherApis\Response\Forecast;

use App\Enums\WeatherApiEnum;
use App\Enums\WeatherForecastStatusEnum;
use App\Models\WeatherForecast;
use DateTimeImmutable;

class WeatherForecastApiItem
{
    protected DateTimeImmutable $dateTime;
    private float $temperature;

    public function __construct(DateTimeImmutable $dateTime, float $temperature)
    {
        $this->dateTime = $dateTime;
        $this->temperature = $temperature;
    }

    public function adaptToWeatherForecast(int $locationId, WeatherApiEnum $weatherApiEnum): WeatherForecast
    {
        return new WeatherForecast([
            'location_id' => $locationId,
            'datetime' => $this->dateTime,
            'status' => WeatherForecastStatusEnum::CREATED,
            'temperature' => $this->temperature,
            'weather_system' => $weatherApiEnum->value,
            // Добавьте другие необходимые поля для хранения данных о прогнозе погоды
        ]);
    }
}
