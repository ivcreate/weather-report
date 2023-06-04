<?php

declare(strict_types=1);

namespace App\Services\WeatherApis;

use App\Enums\WeatherApiEnum;
use App\Services\WeatherApis\Response\Forecast\WeatherForecastApiCollection;
use App\Services\WeatherApis\Response\WeatherApiResponseAdapter;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Log;

class WeatherapiClient implements WeatherApiClientInterface
{
    private string $apiKey;
    private string $apiHost;
    private Client $httpClient;

    public function __construct()
    {
        $this->apiKey = env('WEATHERAPI_API_KEY');
        $this->apiHost = env('WEATHERAPI_API_HOST');
        $this->httpClient = new Client();
    }

    public function forecast(int $countDays, string $location): WeatherForecastApiCollection
    {
        try {
            $data = $this->sendRequest(
                method: 'GET',
                path: '/v1/forecast.json',
                queryOptions: [
                    'key' => $this->apiKey,
                    'q' => $location,
                    'days' => $countDays,
                ]
            );

            return WeatherApiResponseAdapter::weatherapiAdapter($data['forecast']['forecastday']);
        } catch (GuzzleException $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString()
                ]
            );

            throw new \Exception("Можно вернуть пустой WeatherForecastApiCollection а можно создать нормальное исключение которое ловить и обрабатывать без падения");
        }
    }

    public function isRealLocation(string $location)
    {
        try {
            $data = $this->sendRequest(
                method: 'GET',
                path: '/v1/current.json',
                queryOptions: [
                    'key' => $this->apiKey,
                    'q' => $location
                ]
            );

            dd($data);
        } catch (GuzzleException $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString()
                ]
            );

            return 123;
        }
    }

    /**
     * @throws GuzzleException
     */
    private function sendRequest(string $method, string $path, array $queryOptions = [], array $options = []): ?array
    {
        $uri = new Uri();
        $uri = $uri->withScheme('https')
            ->withHost($this->apiHost)
            ->withPath($path)
            ->withQuery(http_build_query($queryOptions));

        $response = $this->httpClient->request($method, $uri, $options);

        return json_decode($response->getBody()->getContents(), true);
    }
}
