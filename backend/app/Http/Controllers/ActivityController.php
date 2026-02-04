<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ActivityController extends Controller
{
    public function __construct(
        protected ActivityService $activityService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $activities = $this->activityService->getAll($user);

        return ActivityResource::collection($activities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreActivityRequest $request): JsonResponse
    {
        $user = auth()->user();
        $activity = $this->activityService->create($user, $request->validated());

        return (new ActivityResource($activity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity): ActivityResource|JsonResponse
    {
        $user = auth()->user();
        $activity = $this->activityService->getById($user, $activity->id);

        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], Response::HTTP_NOT_FOUND);
        }

        return new ActivityResource($activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity): ActivityResource|JsonResponse
    {
        $user = auth()->user();
        $activity = $this->activityService->getById($user, $activity->id);

        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], Response::HTTP_NOT_FOUND);
        }

        $this->activityService->update($activity, $request->validated());
        $activity->refresh();

        return new ActivityResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity): JsonResponse
    {
        $user = auth()->user();
        $activity = $this->activityService->getById($user, $activity->id);

        if (! $activity) {
            return response()->json(['message' => 'Activity not found'], Response::HTTP_NOT_FOUND);
        }

        $this->activityService->delete($activity);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

