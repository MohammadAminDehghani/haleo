<?php

namespace App\Services;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    /**
     * Get all articles for a user.
     */
    public function getAll(User $user): Collection
    {
        return Article::where('user_id', $user->id)->get();
    }

    /**
     * Get paginated articles for a user.
     */
    public function getPaginated(User $user, int $perPage = 15): LengthAwarePaginator
    {
        return Article::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get a specific article by ID for a user.
     */
    public function getById(User $user, int $id): ?Article
    {
        return Article::where('user_id', $user->id)
            ->where('id', $id)
            ->first();
    }

    /**
     * Create a new article for a user.
     */
    public function create(User $user, array $data): Article
    {
        $data['user_id'] = $user->id;

        return Article::create($data);
    }

    /**
     * Update an article.
     */
    public function update(Article $article, array $data): bool
    {
        return $article->update($data);
    }

    /**
     * Delete an article.
     */
    public function delete(Article $article): bool
    {
        return $article->delete();
    }
}

