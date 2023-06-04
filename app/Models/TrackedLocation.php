<?php

declare(strict_types=1);

namespace App\Models;

use App\Http\Requests\CreateTrackedLocationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TrackedLocation",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="location_name", type="string"),
 *     @OA\Property(ref="#/components/schemas/TrackedLocationStatusEnum", property="status"),
 *     @OA\Property(property="latitude", type="number", nullable=true),
 *     @OA\Property(property="longitude", type="number", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 *
 * @method static create(CreateTrackedLocationRequest $input)
 * @method static findOrFail(int $id)
 */
class TrackedLocation extends Model
{
    use HasFactory;

    protected $fillable = ['location_name', 'status', 'latitude', 'longitude'];

    public function weatherForecasts()
    {
        return $this->hasMany(WeatherForecast::class, 'location_id');
    }
}
