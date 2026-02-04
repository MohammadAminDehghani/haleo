<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $articles = $this->articleService->getAll($user);

        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request): JsonResponse
    {
        $user = auth()->user();
        $article = $this->articleService->create($user, $request->validated());

        return (new ArticleResource($article))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article): ArticleResource|JsonResponse
    {
        $user = auth()->user();
        $article = $this->articleService->getById($user, $article->id);

        if (! $article) {
            return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article): ArticleResource|JsonResponse
    {
        $user = auth()->user();
        $article = $this->articleService->getById($user, $article->id);

        if (! $article) {
            return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $this->articleService->update($article, $request->validated());
        $article->refresh();

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article): JsonResponse
    {
        $user = auth()->user();
        $article = $this->articleService->getById($user, $article->id);

        if (! $article) {
            return response()->json(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }

        $this->articleService->delete($article);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

