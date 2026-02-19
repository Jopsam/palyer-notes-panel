<?php

namespace App\Http\Middleware;

use App\Enums\Roles;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAgentOrViewer
{
    /**
     * Handle an incoming request.
     * If the user is not authenticated or does not have the "agent" role, abort with a 403 response.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()
            || !auth()->user()->hasAnyRole([Roles::AGENT->value, Roles::VIEWER->value])
        ) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
