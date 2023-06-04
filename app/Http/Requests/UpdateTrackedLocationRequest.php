<?php

declare(strict_types=1);

namespace App\Http\Requests;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateTrackedLocationRequest",
 *     title="Update Tracked Location Request",
 *     required={"location_name"},
 *     @OA\Property(
 *         property="location_name",
 *         type="string",
 *         maxLength=50,
 *         minLength=2,
 *         example="Sample Location"
 *     )
 * )
 */
class UpdateTrackedLocationRequest extends ApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'location_name' => 'required|string|max:50|min:2|unique:tracked_locations',
        ];
    }
}
