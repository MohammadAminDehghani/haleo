<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    /**
     * Get all Users for a user.
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Get paginated Users for a user.
     */
    public function getPaginated(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return User::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get a specific User by ID for a user.
     */
    public function getById(User $user, int $id): ?User
    {
        return User::where('id', $id)
            ->first();
    }

    /**
     * Create a new User for a user.
     */
    public function create(User $user, array $data): User
    {
        $data['user_id'] = $user->id;

        return User::create($data);
    }

    /**
     * Update an User.
     */
    public function update(User $User, array $data): bool
    {
        return $User->update($data);
    }

    /**
     * Delete an User.
     */
    public function delete(User $User): bool
    {
        return $User->delete();
    }
}

