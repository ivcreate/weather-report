<?php

declare(strict_types=1);

namespace App\Enums;

enum WeatherForecastStatusEnum: string
{
    case CREATED = 'created';
    case FAILED = 'failed';
    case COMPLETED = 'completed';
}
