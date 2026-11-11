<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{

    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        //Enforce Authentication check first
        if (!auth()->check()) {
            abort(401, 'unauthenticated user context');
        }
        if (!auth()->user()->hasRole($roles)) {
            abort(401, 'unauthenticated access to this clinic module');
        }
        return $next($request);
    }
}
