<?php

declare(strict_types=1);

namespace App\Services\WeatherApis\Response\Forecast;

class WeatherForecastApiCollection
{
    /**
     * @var array<WeatherForecastApiItem>
     */
    protected array $items = [];

    public function addItem(WeatherForecastApiItem $item): void
    {
        $this->items[] = $item;
    }

    /**
     * @return WeatherForecastApiItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
