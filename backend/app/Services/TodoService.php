<?php

namespace App\Services;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoService
{
    /**
     * Get all todos for a user.
     */
    public function getAll(User $user): Collection
    {
        return Todo::where('user_id', $user->id)->get();
    }

    /**
     * Get paginated todos for a user.
     */
    public function getPaginated(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return Todo::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get a specific todo by ID for a user.
     */
    public function getById(User $user, int $id): ?Todo
    {
        return Todo::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new todo for a user.
     */
    public function create(User $user, array $data): Todo
    {
        $data['user_id'] = $user->id;

        return Todo::create($data);
    }

    /**
     * Update a todo.
     */
    public function update(Todo $todo, array $data): bool
    {
        return $todo->update($data);
    }

    /**
     * Delete a todo.
     */
    public function delete(Todo $todo): bool
    {
        return $todo->delete();
    }
}

