<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityService
{
    /**
     * Get all activities for a user.
     */
    public function getAll(User $user): Collection
    {
        return Activity::where('user_id', $user->id)->get();
    }

    /**
     * Get paginated activities for a user.
     */
    public function getPaginated(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return Activity::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get a specific activity by ID for a user.
     */
    public function getById(User $user, int $id): ?Activity
    {
        return Activity::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new activity for a user.
     */
    public function create(User $user, array $data): Activity
    {
        $data['user_id'] = $user->id;

        return Activity::create($data);
    }

    /**
     * Update an activity.
     */
    public function update(Activity $activity, array $data): bool
    {
        return $activity->update($data);
    }

    /**
     * Delete an activity.
     */
    public function delete(Activity $activity): bool
    {
        return $activity->delete();
    }
}

