<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        // API clients always get JSON (e.g. 422 validation errors) instead of HTML or redirects
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
