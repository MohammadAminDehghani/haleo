<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthService
{
    /**
     * Authenticate user with email and password.
     */
    public function login(string $email, string $password): ?array
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return null;
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;
        $expiresAt = $tokenResult->token->expires_at;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt?->toIso8601String(),
            'user' => $user,
        ];
    }

    /**
     * Revoke the current access token.
     */
    public function logout(User $user): bool
    {
        $token = $user->token();
        if ($token) {
            $token->revoke();
        }

        return true;
    }

    /**
     * Refresh the access token.
     */
    public function refreshToken(User $user): array
    {
        // Revoke old token if exists
        $oldToken = $user->token();
        if ($oldToken) {
            $oldToken->revoke();
        }

        // Create new token
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->accessToken;
        $expiresAt = $tokenResult->token->expires_at;

        return [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiresAt?->toIso8601String(),
        ];
    }

    /**
     * Get the authenticated user.
     */
    public function getUser(User $user): User
    {
        return $user;
    }
}

