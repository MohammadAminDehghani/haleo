<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {
    }

    /**
     * Login user and return access token.
     */
    public function login(LoginRequest $request): JsonResponse|AuthResource
    {
        $credentials = $request->validated();
        $result = $this->authService->login(
            $credentials['email'],
            $credentials['password']
        );

        if (! $result) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new AuthResource($result);
    }

    /**
     * Logout the authenticated user.
     */
    public function logout(): JsonResponse
    {
        $user = auth()->user();

        if ($user) {
            $this->authService->logout($user);
        }

        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh the access token.
     */
    public function refresh(): JsonResponse|AuthResource
    {
        $user = auth()->user();

        if (! $user) {
            return response()->json([
                'message' => 'Unauthenticated',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $result = $this->authService->refreshToken($user);
        // Include user in refresh response
        $result['user'] = $user;

        return new AuthResource($result);
    }

    /**
     * Get the authenticated user.
     */
    public function user(): UserResource
    {
        $user = auth()->user();

        return new UserResource($user);
    }
}

