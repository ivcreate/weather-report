<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherForecast extends Model
{
    use HasFactory;

    protected $table = 'weather_forecasts';

    protected $fillable = [
        'location_id',
        'datetime',
        'temperature',
        'weather_system',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(TrackedLocation::class, 'location_id');
    }
}
