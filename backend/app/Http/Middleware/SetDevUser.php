<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetDevUser
{
    /**
     * Handle an incoming request.
     *
     * Set user 1 as authenticated user for development purposes.
     * TODO: Remove this middleware when implementing proper authentication.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::find(1);

        if ($user) {
            auth()->setUser($user);
        }

        return $next($request);
    }
}

