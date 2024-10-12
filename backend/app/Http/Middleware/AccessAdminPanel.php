<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\AuthenticationException;

class AccessAdminPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token_name = PersonalAccessToken::findToken($request->bearerToken())->name;
        if ($token_name == "admin_auth_token") {
            return $next($request);
        }
        throw new AuthenticationException('Unauthenticated.');
    }
}
