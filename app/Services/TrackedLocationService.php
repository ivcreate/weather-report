<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TrackedLocationStatusEnum;
use App\Http\Requests\CreateTrackedLocationRequest;
use App\Http\Requests\UpdateTrackedLocationRequest;
use App\Jobs\TrackedLocationCreateJob;
use App\Models\TrackedLocation;
use Illuminate\Database\Eloquent\Collection;

class TrackedLocationService
{
    public function getAllTrackedLocations(): Collection
    {
        return TrackedLocation::all();
    }

    public function createTrackedLocation(CreateTrackedLocationRequest $request): void
    {
        $trackedLocation = TrackedLocation::create($request->input());

        TrackedLocationCreateJob::dispatch($trackedLocation);
    }

    public function getTrackedLocationById(int $id): TrackedLocation
    {
        return TrackedLocation::findOrFail($id);
    }

    public function updateTrackedLocation(int $id, UpdateTrackedLocationRequest $request): void
    {
        $trackedLocation = TrackedLocation::findOrFail($id);
        $trackedLocation->status = TrackedLocationStatusEnum::PENDING;

        $trackedLocation->update($request->input());

        TrackedLocationCreateJob::dispatch($trackedLocation);
    }

    public function deleteTrackedLocation(int $id): void
    {
        $trackedLocation = TrackedLocation::findOrFail($id);
        $trackedLocation->delete();
    }

    public function processingTrackedLocation(TrackedLocation $trackedLocation)
    {
        $trackedLocation->status = TrackedLocationStatusEnum::PROCESSING;

        $trackedLocation->save();
    }
}
