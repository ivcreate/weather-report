<?php

namespace App\Console\Commands;

use App\Enums\WeatherApiEnum;
use App\Models\WeatherForecast;
use App\Services\WeatherApis\Response\Forecast\WeatherForecastApiCollection;
use App\Services\WeatherApis\Response\WeatherApiResponseAdapter;
use App\Services\WeatherApis\WeatherApiClientFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class WeatherDataCollectorCommand extends Command
{
    protected $signature = 'app:weather-data-collector';

    protected $description = 'Collect weather data from multiple APIs';

    public function handle()
    {
        $weatherApisEnum = WeatherApiEnum::cases();

        foreach ($weatherApisEnum as $weatherApiEnum) {
            DB::transaction(function () use ($weatherApiEnum) {
                //здесь я задумывал выбрать все локации у которых статус completed для того чтобы по ним пробежатся и собрать дату
                $this->processWeatherData($weatherApiEnum);
            });
        }
    }

    private function processWeatherData(WeatherApiEnum $weatherApiEnum): void //здесь я задумывал еще принимать локацию для того чтобы по ней запрашивать прогноз на определенное кол-во дней вперед которое надо бы по делу определить для сервиса
    {
        $weatherApiClient = WeatherApiClientFactory::create($weatherApiEnum);

        $weatherForecastApiCollection = $weatherApiClient->forecast(2,'Moscow');//примерные данные

        foreach ($weatherForecastApiCollection->getItems() as $item) { // это в идеале вообще вынести в сервис прогноза
            $weatherForecast = $item->adaptToWeatherForecast(1, $weatherApiEnum);
            $weatherForecast->save();
        }
    }
}
