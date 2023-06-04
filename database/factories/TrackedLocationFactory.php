<?php

namespace Database\Factories;

use App\Models\TrackedLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackedLocation>
 */
class TrackedLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrackedLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'location_name' => $this->faker->city,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
