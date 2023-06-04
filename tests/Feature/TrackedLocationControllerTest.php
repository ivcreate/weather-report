<?php

namespace Tests\Feature;

use App\Models\TrackedLocation;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackedLocationControllerTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testIndex()
    {
        $trackedLocations = TrackedLocation::factory()->count(5)->create();

        $response = $this->getJson('/api/tracked-locations');

        $response->assertSuccessful();
        $response->assertJson($trackedLocations->toArray());
    }

    public function testStore()
    {
        $data = [
            'name' => $this->faker->city
        ];

        $response = $this->postJson('/api/tracked-locations', $data);

        $response->assertStatus(201);
        $response->assertJson($data);
    }

    public function testShow()
    {
        $trackedLocation = TrackedLocation::factory()->create();

        $response = $this->getJson('/api/tracked-locations/' . $trackedLocation->id);

        $response->assertSuccessful();
        $response->assertJson($trackedLocation->toArray());
    }
}
