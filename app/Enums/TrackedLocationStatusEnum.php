<?php

declare(strict_types=1);

namespace App\Enums;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="TrackedLocationStatusEnum",
 *     description="Tracked location status enum",
 *     type="string",
 *     enum={"pending", "processing", "completed"}
 * )
 */
enum TrackedLocationStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
}
