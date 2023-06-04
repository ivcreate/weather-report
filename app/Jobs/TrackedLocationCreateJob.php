<?php

namespace App\Jobs;

use App\Models\TrackedLocation;
use App\Services\TrackedLocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackedLocationCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private TrackedLocation $trackedLocation
    ) {}

    /**
     * Execute the job.
     */
    public function handle(TrackedLocationService $trackedLocationService): void
    {
        $trackedLocationService->processingTrackedLocation($this->trackedLocation);
    }
}
