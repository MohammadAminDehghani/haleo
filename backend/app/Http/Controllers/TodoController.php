<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    public function __construct(
        protected TodoService $todoService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $user = auth()->user();
        $todos = $this->todoService->getAll($user);

        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request): JsonResponse
    {
        $user = auth()->user();
        $todo = $this->todoService->create($user, $request->validated());

        return (new TodoResource($todo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo): TodoResource|JsonResponse
    {
        $user = auth()->user();
        $todo = $this->todoService->getById($user, $todo->id);

        if (! $todo) {
            return response()->json(['message' => 'Todo not found'], Response::HTTP_NOT_FOUND);
        }

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource|JsonResponse
    {
        $user = auth()->user();
        $todo = $this->todoService->getById($user, $todo->id);

        if (! $todo) {
            return response()->json(['message' => 'Todo not found'], Response::HTTP_NOT_FOUND);
        }

        $this->todoService->update($todo, $request->validated());
        $todo->refresh();

        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo): JsonResponse
    {
        $user = auth()->user();
        $todo = $this->todoService->getById($user, $todo->id);

        if (! $todo) {
            return response()->json(['message' => 'Todo not found'], Response::HTTP_NOT_FOUND);
        }

        $this->todoService->delete($todo);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

