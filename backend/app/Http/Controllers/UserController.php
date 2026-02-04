<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected UserService $UserService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $Users = $this->UserService->getAll();

        return UserResource::collection($Users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = auth()->user();
        $User = $this->UserService->create($user, $request->validated());

        return (new UserResource($User))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User): UserResource
    {
        // $user = auth()->user();
        $user = User::find(1);
        $User = $this->UserService->getById($user, $User->id);

        if (! $User) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return new UserResource($User);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $User): UserResource|JsonResponse
    {
        $user = auth()->user();
        $User = $this->UserService->getById($user, $User->id);

        if (! $User) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $this->UserService->update($User, $request->validated());
        $User->refresh();

        return new UserResource($User);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $User): JsonResponse
    {
        $user = auth()->user();
        $User = $this->UserService->getById($user, $User->id);

        if (! $User) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $this->UserService->delete($User);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}

