<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Public;

use App\Http\Requests\CreateTrackedLocationRequest;
use App\Http\Requests\UpdateTrackedLocationRequest;
use App\Services\TrackedLocationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

/**
 * @OA\Info(
 *      description="Methods for work with tracked locations",
 *      version="1.0.0",
 *      title="Tracked locations"
 * )
 */
class TrackedLocationController extends Controller
{
    private TrackedLocationService $trackedLocationService;

    public function __construct(TrackedLocationService $trackedLocationService)
    {
        $this->trackedLocationService = $trackedLocationService;
    }

    /**
     * @OA\Get(
     *     path="/api/tracked-locations",
     *     summary="Get all tracked locations",
     *     tags={"Tracked Locations"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/TrackedLocation")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $trackedLocations = $this->trackedLocationService->getAllTrackedLocations();

            return response()->json($trackedLocations);
        } catch (Throwable $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'request' => request()->all(),
                ]
            );

            return response()->json(['error' => 'Oooops some error'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/tracked-locations",
     *     summary="Create a new tracked location",
     *     tags={"Tracked Locations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateTrackedLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * @param CreateTrackedLocationRequest $createTrackedLocationRequest
     *
     * @return JsonResponse
     */
    public function store(CreateTrackedLocationRequest $createTrackedLocationRequest): JsonResponse
    {
        try {
            $this->trackedLocationService->createTrackedLocation($createTrackedLocationRequest);

            return response()->json(null, ResponseAlias::HTTP_CREATED);
        } catch (Throwable $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'request' => request()->all(),
                ]
            );

            return response()->json(['error' => 'Oooops some error'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/tracked-locations/{id}",
     *     summary="Get a tracked location by ID",
     *     tags={"Tracked Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the tracked location",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/TrackedLocation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tracked location not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $trackedLocation = $this->trackedLocationService->getTrackedLocationById($id);

            return response()->json($trackedLocation);
        } catch (ModelNotFoundException) {
            return response()->json(null, ResponseAlias::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'request' => request()->all(),
                ]
            );

            return response()->json(['error' => 'Oooops some error'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/tracked-locations/{id}",
     *     summary="Update a tracked location",
     *     tags={"Tracked Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the tracked location",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateTrackedLocationRequest")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Location updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TrackedLocation")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tracked location not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * @param UpdateTrackedLocationRequest $updateTrackedLocationRequest
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTrackedLocationRequest $updateTrackedLocationRequest, int $id): JsonResponse
    {
        try {
            $this->trackedLocationService->updateTrackedLocation($id, $updateTrackedLocationRequest);

            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException) {
            return response()->json(null, ResponseAlias::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'request' => request()->all(),
                ]
            );

            return response()->json(['error' => 'Oooops some error'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/tracked-locations/{id}",
     *     summary="Delete a tracked location",
     *     tags={"Tracked Locations"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the tracked location",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Tracked location deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tracked location not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     *
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->trackedLocationService->deleteTrackedLocation($id);

            return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException) {
            return response()->json(null, ResponseAlias::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            Log::channel('error')->error(
                $exception->getMessage(),
                [
                    'trace' => $exception->getTraceAsString(),
                    'request' => request()->all(),
                ]
            );

            return response()->json(['error' => 'Oooops some error'], ResponseAlias::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
